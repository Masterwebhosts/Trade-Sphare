<?php

namespace App\Services\Tracking;

use App\Models\Ad;
use App\Models\Click;
use App\Models\AdClickDedup;
use App\Services\Fraud\FraudDetectionService;
use App\Services\Ledger\LedgerService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClickService
{
    public function __construct(
        protected FraudDetectionService $fraud,
        protected LedgerService $ledger,
    ) {
    }


    public function record(
        Ad $ad,
        Request $request,
        array $context = []
    ): ?Click {


        $zone = $context['zone'] ?? null;


        if (! $zone || ! $zone->isServeable()) {

            logger()->warning(
                'Click dropped (invalid zone)',
                [
                    'ad_id' => $ad->id,
                    'zone_id' => $zone?->id,
                ]
            );

            return null;
        }



        $ip = $request->ip();

        $ua = (string) $request->userAgent();



        $fingerprint = sha1(
            $ip
            . '|'
            . $ua
            . '|'
            . $request->header('Accept-Language')
        );



        $fraud = $this->fraud->analyzeClick(
            $ad,
            $request
        );


        $isFraud = $fraud['is_fraud'] ?? false;



        try {


            /*
            |--------------------------------------------------------------------------
            | STEP 1
            | Store click + dedup protection
            |--------------------------------------------------------------------------
            */


            $click = DB::transaction(function () use (
                $ad,
                $zone,
                $ip,
                $ua,
                $fingerprint,
                $isFraud
            ) {


                $dedup = AdClickDedup::query()

                    ->where('ad_id', $ad->id)

                    ->where('zone_id', $zone->id)

                    ->where('fingerprint', $fingerprint)

                    ->first();



                /*
                 * Block duplicate clicks
                 * within 10 minutes
                 */

                if (
                    $dedup
                    &&
                    ! $dedup->isExpired(10)
                ) {


                    logger()->info(
                        'Duplicate click blocked',
                        [
                            'ad_id'=>$ad->id,
                            'zone_id'=>$zone->id,
                            'fingerprint'=>$fingerprint,
                        ]
                    );


                    return null;

                }



                /*
                 * Update or create dedup record
                 */

                if ($dedup) {


                    $dedup->update([

                        'last_click_at'=>now(),

                    ]);


                } else {


                    AdClickDedup::create([

                        'ad_id'=>$ad->id,

                        'zone_id'=>$zone->id,

                        'fingerprint'=>$fingerprint,

                        'last_click_at'=>now(),

                    ]);

                }




                /*
                 * Permanent click record
                 */

                return Click::create([


                    'ad_id'=>$ad->id,


                    'publisher_id'=>$zone->publisher_id,


                    'zone_id'=>$zone->id,


                    'ip_address'=>$ip,


                    'user_agent'=>substr(
                        $ua,
                        0,
                        255
                    ),


                    'fingerprint'=>$fingerprint,


                    'is_fraud'=>$isFraud,


                ]);

            });





            /*
            |--------------------------------------------------------------------------
            | Duplicate click
            |--------------------------------------------------------------------------
            */

            if (! $click) {

                return null;

            }




            /*
            |--------------------------------------------------------------------------
            | STEP 2
            | Ledger
            |--------------------------------------------------------------------------
            */


            if (
                ! $isFraud
                &&
                $ad->campaign
            ) {


                $cpc = (float) $ad->campaign->cpc;



                if ($cpc > 0) {


                    try {


                        $this->ledger->chargeClickWithSplit(

                            campaignId:$ad->campaign_id,


                            advertiserId:$ad->campaign->advertiser_id,


                            publisherId:$zone->publisher_id,


                            amount:$cpc,


                            clickId:$click->id

                        );


                    } catch (\Throwable $e) {


                        logger()->error(
                            'Ledger failed after click creation',
                            [

                                'click_id'=>$click->id,

                                'ad_id'=>$ad->id,

                                'error'=>$e->getMessage(),

                            ]
                        );


                    }

                }

            }



            return $click;




        } catch (QueryException $e) {



            /*
            |--------------------------------------------------------------------------
            | Database duplicate constraint
            |--------------------------------------------------------------------------
            */


            if (

                $e->getCode() === '23000'

                ||

                (($e->errorInfo[1] ?? null) === 1062)

            ) {


                logger()->info(
                    'Duplicate click blocked by database',
                    [

                        'ad_id'=>$ad->id,

                        'fingerprint'=>$fingerprint,

                    ]
                );


                return null;

            }



            throw $e;

        }

    }
}