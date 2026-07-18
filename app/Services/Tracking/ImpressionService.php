<?php

namespace App\Services\Tracking;

use App\Models\Impression;
use App\Models\AdImpressionDedup;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ImpressionService
{
    /**
     * Record impression with database deduplication
     *
     * - Database unique constraint protection
     * - Safe for concurrent requests
     * - Atomic dedup + impression creation
     */
    public function record($ad, Request $request, array $context = []): ?Impression
    {
        if (! $ad) {
            return null;
        }


        $zone = $context['zone'] ?? null;


        if (! $zone || ! $zone->isServeable()) {
            return null;
        }


        $ip = $request->ip();

        $ua = (string) $request->userAgent();


        $fingerprint = sha1(
            $ip . '|' . $ua
        );


        try {

            return DB::transaction(function () use (
                $ad,
                $zone,
                $ip,
                $ua,
                $fingerprint
            ) {

                AdImpressionDedup::create([

                    'ad_id' => $ad->id,

                    'zone_id' => $zone->id,

                    'fingerprint' => $fingerprint,

                    'last_impression_at' => now(),

                ]);


                return Impression::create([

                    'ad_id' => $ad->id,

                    'campaign_id' => $ad->campaign_id,

                    'publisher_id' => $zone->publisher_id,

                    'zone_id' => $zone->id,

                    'ip_address' => $ip,

                    'user_agent' => substr(
                        $ua,
                        0,
                        255
                    ),

                    'fingerprint' => $fingerprint,

                ]);

            });


        } catch (QueryException $e) {

            /*
             * Duplicate impression blocked
             * by database unique constraint
             */
            if (
                $e->getCode() === '23000'
                ||
                (($e->errorInfo[1] ?? null) === 1062)
            ) {
                return null;
            }


            throw $e;
        }
    }
}
