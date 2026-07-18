<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdZone;

class AdServeController extends Controller
{
    /**
     * SERVE AD BY ZONE TOKEN
     */
    public function serve(string $token)
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
                    'active'
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
        | 4. Render
        |--------------------------------------------------------------------------
        */

        return view('ads.embed', [

            'ad'   => $ad,

            'zone' => $zone,

        ]);

    }
}