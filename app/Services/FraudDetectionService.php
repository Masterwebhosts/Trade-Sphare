<?php

namespace App\Services;

use App\Models\Click;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ad;

class FraudDetectionService
{
    /**
     * Analyze click fraud
     */
    public function analyzeClick(
        Ad $ad,
        Request $request
    ): array {

        $ip = $request->ip();

        $ua = (string) $request->userAgent();


        if (! $ip) {
            return [
                'is_fraud' => true,
                'score'    => 100,
            ];
        }



        $fingerprint = sha1(
            $ip . '|' . $ua
        );



        $isFraud =
            $this->ipSpam($ip)
            ||
            $this->fingerprintSpam($fingerprint)
            ||
            $this->burstActivity($ip)
            ||
            $this->botDetected($ua);



        return [

            'is_fraud' => $isFraud,

            'score' => $isFraud
                ? 100
                : 0,

        ];
    }



    /**
     * Too many clicks from same IP
     */
    private function ipSpam(string $ip): bool
    {
        return Click::query()

            ->where('ip_address', $ip)

            ->where(
                'created_at',
                '>=',
                Carbon::now()->subMinute()
            )

            ->count() >= 10;
    }



    /**
     * Same visitor fingerprint clicking repeatedly
     */
    private function fingerprintSpam(
        string $fingerprint
    ): bool {

        return Click::query()

            ->where(
                'fingerprint',
                $fingerprint
            )

            ->where(
                'created_at',
                '>=',
                Carbon::now()->subMinutes(5)
            )

            ->count() >= 3;
    }



    /**
     * Burst clicking
     */
    private function burstActivity(string $ip): bool
    {
        return Click::query()

            ->where('ip_address', $ip)

            ->where(
                'created_at',
                '>=',
                Carbon::now()->subSeconds(10)
            )

            ->count() >= 5;
    }



    /**
     * Basic bot detection
     */
    private function botDetected(
        ?string $ua
    ): bool {

        if (! $ua) {
            return false;
        }


        $ua = strtolower($ua);



        foreach (
            [
                'bot',
                'crawler',
                'spider',
                'curl',
                'wget',
                'python',
                'scrapy',
            ]
            as $bot
        ) {

            if (
                str_contains(
                    $ua,
                    $bot
                )
            ) {
                return true;
            }
        }



        return false;
    }
}