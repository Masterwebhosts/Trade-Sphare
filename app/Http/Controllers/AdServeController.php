<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdZone;
use App\Services\Tracking\ImpressionService;
use Illuminate\Http\Request;


class AdServeController extends Controller
{

    public function __construct(
        protected ImpressionService $impressionService
    ){
    }

    /**
     * SERVE AD BY ZONE TOKEN
     */
    
     public function serve(
    Request $request,
    string $token
)
{

        /*
        |--------------------------------------------------------------------------
        | 1. Load zone
        |--------------------------------------------------------------------------
        */

        $zone = AdZone::where('token', $token)
            ->where('status', 'active')
            ->first();


        if (! $zone) {

            return response()
                ->view('ads.empty');

        }



        /*
        |--------------------------------------------------------------------------
        | 2. Select active ad
        |--------------------------------------------------------------------------
        */

        $ad = Ad::query()
            ->where('status', Ad::STATUS_ACTIVE)
            ->whereHas('campaign', function ($query) {

                $query->where(
                    'status',
                    'approved'
                );

            })
            ->whereHas('zones', function ($query) use ($zone) {

                $query->where(
                    'ad_zones.id',
                    $zone->id
                );

            })
            ->latest()
            ->first();



        /*
        |--------------------------------------------------------------------------
        | 3. No ads
        |--------------------------------------------------------------------------
        */

        if (! $ad) {

            return response()
                ->view(
                    'ads.empty',
                    compact('zone')
                );

        }



        /*
        |--------------------------------------------------------------------------
        | 4. Record Impression
        |--------------------------------------------------------------------------
        */

        $this->impressionService->record(
            $ad,
            request(),
            [
                'zone' => $zone,
                'publisher_id' => $zone->publisher_id,
                'zone_id' => $zone->id,
                'channel' => 'embed',
            ]
        );



        /*
        |--------------------------------------------------------------------------
        | 5. Render
        |--------------------------------------------------------------------------
        */

        return view('ads.embed', [

            'ad'   => $ad,

            'zone' => $zone,

        ]);

    }
}