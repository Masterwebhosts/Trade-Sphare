<?php

namespace App\Services\Fraud;

use App\Models\Ad;
use App\Models\Click;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FraudDetectionService
{
    /**
     * Analyze click fraud.
     */
    public function analyzeClick(
        Ad $ad,
        Request $request
    ): array {

        $score = 0;
        $flags = [];

        $ip = $request->ip();
        $ua = (string) $request->userAgent();

        /*
        |--------------------------------------------------------------------------
        | Missing IP
        |--------------------------------------------------------------------------
        */
        if (! $ip) {

            $score += 50;

            $flags[] = 'missing_ip';
        }

        /*
        |--------------------------------------------------------------------------
        | High click velocity (Cache)
        |--------------------------------------------------------------------------
        */
        if ($ip) {

            $velocityKey = "fraud:velocity:{$ip}";

            $count = Cache::get(
                $velocityKey,
                0
            );

            if ($count >= 10) {

                $score += 30;

                $flags[] = 'high_frequency_ip';
            }

            Cache::put(
                $velocityKey,
                $count + 1,
                now()->addMinutes(10)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Recent clicks in database
        |--------------------------------------------------------------------------
        */
        if ($ip) {

            $recentClicks = Click::query()

                ->where('ad_id', $ad->id)

                ->where('ip_address', $ip)

                ->where(
                    'created_at',
                    '>=',
                    now()->subMinutes(10)
                )

                ->count();

            if ($recentClicks > 10) {

                $score += 20;

                $flags[] = 'repeated_clicks';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Invalid User Agent
        |--------------------------------------------------------------------------
        */
        if (
            empty($ua)
            ||
            strlen($ua) < 20
        ) {

            $score += 20;

            $flags[] = 'invalid_user_agent';
        }

        /*
        |--------------------------------------------------------------------------
        | Bot Detection
        |--------------------------------------------------------------------------
        */
        if (! empty($ua)) {

            $ua = strtolower($ua);

            $bots = [

                'bot',
                'crawler',
                'spider',
                'curl',
                'wget',
                'python',
                'headless',
                'selenium',

            ];

            foreach ($bots as $bot) {

                if (str_contains($ua, $bot)) {

                    $score += 70;

                    $flags[] = 'bot_detected';

                    break;
                }
            }
        }

        $score = min($score, 100);

        return [

            'score' => $score,

            'fraud_score' => $score,

            'is_fraud' => $score >= 50,

            'flags' => $flags,

        ];
    }
}