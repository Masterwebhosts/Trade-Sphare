<?php

namespace App\Http\Controllers;

use App\Models\AdZone;
use App\Services\AdService;

class AdPublicController extends Controller
{
    /**
     * Public embed endpoint
     *
     * /embed/zones/{token}
     */
    public function embed(
        string $token,
        AdService $adService
    ) {

        /*
        |--------------------------------------------------------------------------
        | Load Zone
        |--------------------------------------------------------------------------
        */

        $zone = AdZone::where('token', $token)
            ->firstOrFail();



        /*
        |--------------------------------------------------------------------------
        | Validate Zone
        |--------------------------------------------------------------------------
        */

        if (! $zone->isServeable()) {

            return response()
                ->view('ads.empty', [
                    'zone' => $zone,
                ]);

        }



        /*
        |--------------------------------------------------------------------------
        | Select Advertisement
        |--------------------------------------------------------------------------
        */

        $ad = $adService->getAdForZone(
            $zone->id
        );



        /*
        |--------------------------------------------------------------------------
        | Render Advertisement
        |
        | Tracking is handled separately
        |--------------------------------------------------------------------------
        */

        return view('ads.embed', [

            'ad'   => $ad,

            'zone' => $zone,

        ]);

    }
}