<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdZone;
use App\Services\AdService;
use App\Services\Tracking\ImpressionService;
use Illuminate\Http\Request;

class ZoneServeController extends Controller
{
    /**
     * Serve advertisement by zone token
     *
     * /api/zones/{token}/serve
     */
    public function serve(
        string $token,
        AdService $adService,
        Request $request,
        ImpressionService $impressionService
    ) {

        /*
        |--------------------------------------------------------------------------
        | Load Zone
        |--------------------------------------------------------------------------
        */

        $zone = AdZone::where('token', $token)
            ->first();


        if (! $zone) {

            return response()->json([

                'success' => false,

                'message' => 'Zone not found',

                'data' => null,

            ], 404);

        }



        /*
        |--------------------------------------------------------------------------
        | Validate Zone
        |--------------------------------------------------------------------------
        */

        if (! $zone->isServeable()) {

            return response()->json([

                'success' => false,

                'message' => 'Zone is not active',

                'data' => null,

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
                    'channel' => 'api',
                ]
            );

        }



        /*
        |--------------------------------------------------------------------------
        | JSON Response
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'success' => $ad !== null,

            'data' => $ad ? [

                'id' => $ad->id,

                'title' => $ad->title,

                'description' => $ad->description,

                'content_type' => $ad->content_type,

                'media_url' => $ad->media_url,

                'target_url' => $ad->target_url,

                'zone_token' => $zone->token,

            ] : null,

        ]);

    }
}