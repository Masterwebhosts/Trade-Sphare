<?php

namespace App\Services\Fraud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FraudService
{
    /**
     * Main entry point
     * true = allow click
     * false = block click
     */
    public function validateClick(
        int $adId,
        int $publisherId,
        Request $request
    ): bool {
        $ip = $request->ip();
        $userAgent = (string) $request->userAgent();
        $fingerprint = $this->generateFingerprint($request);

        // 1. Hard block: missing UA (common bot indicator)
        if (empty($userAgent)) {
            return false;
        }

        // 2. Bot signature detection (basic but safe)
        if ($this->isBotUserAgent($userAgent)) {
            return false;
        }

        // 3. Per-click idempotency (same event spam protection)
        $clickKey = $this->clickKey($adId, $publisherId, $ip, $fingerprint);

        if (Cache::has($clickKey)) {
            return false;
        }

        Cache::put($clickKey, 1, now()->addSeconds(30));

        // 4. Burst protection per IP
        if ($this->isIpBursting($ip)) {
            return false;
        }

        return true;
    }

    /**
     * Detect simple bot patterns
     */
    private function isBotUserAgent(string $ua): bool
    {
        $ua = strtolower($ua);

        $patterns = [
            'bot',
            'crawler',
            'spider',
            'headless',
            'curl',
            'wget',
            'python',
            'scrapy',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Burst detection per IP
     */
    private function isIpBursting(string $ip): bool
    {
        $key = "fraud:ip:burst:{$ip}";

        $count = Cache::get($key, 0);

        if ($count >= 25) {
            return true;
        }

        Cache::put($key, $count + 1, now()->addSeconds(60));

        return false;
    }

    /**
     * Generate stable fingerprint
     */
    private function generateFingerprint(Request $request): string
    {
        return hash('sha256',
            $request->ip() .
            '|' .
            substr((string) $request->userAgent(), 0, 120)
        );
    }

    /**
     * Unique click key (idempotency layer)
     */
    private function clickKey(
        int $adId,
        int $publisherId,
        string $ip,
        string $fingerprint
    ): string {
        return "fraud:click:{$adId}:{$publisherId}:{$ip}:{$fingerprint}";
    }
}
