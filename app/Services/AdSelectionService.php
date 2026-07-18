<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdZone;
use App\Services\Cache\AdCacheService;

class AdSelectionService
{
    public function __construct(
        protected AdCacheService $cache
    ) {
    }



    /**
     * Entry point
     */
    public function serve(
    ?int $zoneId = null,
    ?int $publisherId = null,
    ?string $ip = null
): ?Ad {

    if (! $zoneId) {
        return null;
    }

    $zone = AdZone::find($zoneId);

    if (! $zone) {
        return null;
    }

    return $this->select($zone->token);

}
    /**
     * Select suitable ad for zone
     */
    public function select(
        ?string $zoneToken = null
    ): ?Ad {

        $zone = null;



        /*
        |--------------------------------------------------------------------------
        | Load Zone By Token
        |--------------------------------------------------------------------------
        */

        if ($zoneToken) {


            $zone = AdZone::query()

                ->where(
                    'token',
                    $zoneToken
                )

                ->with([
                    'ads.campaign'
                ])

                ->first();



            if (
                ! $zone ||
                ! $zone->isServeable()
            ) {

                return null;

            }

        }





        /*
        |--------------------------------------------------------------------------
        | Get Ads Pool
        |--------------------------------------------------------------------------
        |
        | Priority:
        |
        | 1- Ads assigned to zone
        |
        | 2- Global eligible ads
        |
        |--------------------------------------------------------------------------
        */


        if (
            $zone &&
            $zone->ads->isNotEmpty()
        ) {


            $ads = $zone->ads;



        } else {


            $pool = $this->cache->getPool();



            if (empty($pool)) {

                $pool = $this->cache->warmPool();

            }



            if (empty($pool)) {

                return null;

            }



            $ads = Ad::query()

                ->whereIn(
                    'id',
                    collect($pool)
                        ->pluck('id')
                )

                ->with([
                    'campaign'
                ])

                ->get();

        }






        /*
        |--------------------------------------------------------------------------
        | Validate Ads
        |--------------------------------------------------------------------------
        */

        $ads = $ads->filter(
            function (Ad $ad) {

                return $ad->canBeServed();

            }
        );







        /*
        |--------------------------------------------------------------------------
        | Governorate Targeting
        |--------------------------------------------------------------------------
        */

        if ($zone) {


            $ads = $ads->filter(

                function (Ad $ad) use ($zone) {


                    $campaign = $ad->campaign;



                    if (! $campaign) {

                        return false;

                    }





                    /*
                    |--------------------------------------------------------------------------
                    | Campaign has governorate
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $campaign->governorate_id
                    ) {


                        /*
                        |
                        | Zone has governorate
                        |
                        */

                        if (
                            $zone->governorate_id
                        ) {


                            return
                                $campaign->governorate_id
                                ==
                                $zone->governorate_id;


                        }



                        /*
                        |
                        | Zone is global
                        |
                        */


                        return true;


                    }





                    /*
                    |--------------------------------------------------------------------------
                    | Campaign is global
                    |--------------------------------------------------------------------------
                    */

                    return true;


                }

            );


        }








        if ($ads->isEmpty()) {

            return null;

        }







        /*
        |--------------------------------------------------------------------------
        | Ranking / Weight Selection
        |--------------------------------------------------------------------------
        */

        return $this->weightedPick(

            $ads
                ->values()
                ->all()

        );

    }







    /**
     * CPC weighted selection
     */
    protected function weightedPick(
        array $ads
    ): ?Ad {


        $total = 0;



        foreach ($ads as $ad) {


            $total += max(

                0,

                $ad
                    ->campaign
                    ?->cpc ?? 0

            );


        }






        if ($total <= 0) {

            return $ads[0] ?? null;

        }







        $random = mt_rand(

            1,

            (int) ($total * 100)

        ) / 100;





        $current = 0;






        foreach ($ads as $ad) {


            $current += max(

                0,

                $ad
                    ->campaign
                    ?->cpc ?? 0

            );




            if ($random <= $current) {

                return $ad;

            }


        }







        return $ads[0] ?? null;

    }

}