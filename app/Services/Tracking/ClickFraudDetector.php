<?php

namespace App\Services\Tracking;

use Illuminate\Support\Facades\Cache;

class ClickFraudDetector
{
    public function score($adId, $request): int
    {
        $ip = $request->ip();
        $ua = $request->userAgent();

        $score = 100;

        /*
        |--------------------------------------
        | 1. IP frequency penalty
        |--------------------------------------
        */
        $ipKey = "ip_clicks:$ip";
        $ipClicks = Cache::get($ipKey, 0);

        if ($ipClicks > 20) {
            $score -= 50;
        } elseif ($ipClicks > 10) {
            $score -= 25;
        }

        Cache::put($ipKey, $ipClicks + 1, 300);

        /*
        |--------------------------------------
        | 2. User-Agent repetition
        |--------------------------------------
        */
        $uaKey = "ua_clicks:" . sha1($ua);
        $uaClicks = Cache::get($uaKey, 0);

        if ($uaClicks > 50) {
            $score -= 30;
        }

        Cache::put($uaKey, $uaClicks + 1, 300);

        /*
        |--------------------------------------
        | 3. Burst behavior (fast clicking)
        |--------------------------------------
        */
        $burstKey = "burst:$ip";
        $lastClick = Cache::get($burstKey);

        if ($lastClick && now()->diffInSeconds($lastClick) < 2) {
            $score -= 40;
        }

        Cache::put($burstKey, now(), 300);

        return max(0, $score);
    }
}