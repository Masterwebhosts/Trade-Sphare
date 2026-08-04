<?php

namespace App\Services\Tracking;

use App\Models\AdImpressionDedup;
use App\Models\Impression;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImpressionService
{
    /**
     * Record impression with database deduplication.
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

        $fingerprint = sha1($ip . '|' . $ua);

        try {

            // تسجيل بصمة الظهور
            AdImpressionDedup::create([
                'ad_id'             => $ad->id,
                'zone_id'           => $zone->id,
                'fingerprint'       => $fingerprint,
                'last_impression_at'=> now(),
            ]);

            // تسجيل الظهور
            return Impression::create([
                'ad_id'         => $ad->id,
                'campaign_id'   => $ad->campaign_id,
                'publisher_id'  => $zone->publisher_id,
                'zone_id'       => $zone->id,
                'ip_address'    => $ip,
                'user_agent'    => substr($ua, 0, 255),
                'fingerprint'   => $fingerprint,
            ]);

        } catch (QueryException $e) {

            // Duplicate Entry
            if (
                $e->getCode() === '23000' ||
                (($e->errorInfo[1] ?? null) === 1062)
            ) {
                return null;
            }

            throw $e;
        }
    }
}