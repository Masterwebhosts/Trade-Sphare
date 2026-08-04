<?php

namespace App\Http\Controllers;

use App\Models\AdZone;
use App\Services\AdService;
use App\Services\Tracking\ImpressionService;
use Illuminate\Http\Request;

class AdPublicController extends Controller
{
    /**
     * Public embed endpoint
     *
     * /embed/zones/{token}
     */
    public function embed(
        string $token,
        AdService $adService,
        ImpressionService $impressionService,
        Request $request
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

            return response()->view('ads.empty', [
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
        | Record Impression
        |--------------------------------------------------------------------------
        */

        if ($ad) {

            $impressionService->record(
                $ad,
                $request,
                [
                    'zone' => $zone,
                    'publisher_id' => $zone->publisher_id,
                    'zone_id' => $zone->id,
                    'channel' => 'embed',
                ]
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Render Advertisement
        |--------------------------------------------------------------------------
        */

        return view('ads.embed', [

            'ad'   => $ad,

            'zone' => $zone,

        ]);

    }
}