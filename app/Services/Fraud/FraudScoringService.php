<?php

namespace App\Services\Fraud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FraudScoringService
{
    /**
     * Calculate fraud risk score for a click event
     *
     * @return array{
     *   score: int,
     *   reasons: array,
     *   decision: string
     * }
     */
    public function score(
        int $adId,
        int $publisherId,
        Request $request
    ): array {
        $ip = $request->ip();
        $ua = (string) $request->userAgent();

        $score = 0;
        $reasons = [];

        // -------------------------
        // 1. IP velocity check
        // -------------------------
        $ipKey = "fraud:ip:{$ip}";
        $ipCount = Cache::get($ipKey, 0);

        if ($ipCount > 50) {
            $score += 40;
            $reasons[] = 'high_ip_velocity';
        } elseif ($ipCount > 20) {
            $score += 20;
            $reasons[] = 'medium_ip_velocity';
        }

        Cache::put($ipKey, $ipCount + 1, now()->addMinutes(1));

        // -------------------------
        // 2. User-Agent analysis
        // -------------------------
        if ($this->isSuspiciousUserAgent($ua)) {
            $score += 30;
            $reasons[] = 'suspicious_user_agent';
        }

        // -------------------------
        // 3. Burst behavior detection
        // -------------------------
        $burstKey = "fraud:burst:{$ip}";
        $burst = Cache::get($burstKey, 0);

        if ($burst > 30) {
            $score += 30;
            $reasons[] = 'click_burst_detected';
        }

        Cache::put($burstKey, $burst + 1, now()->addSeconds(30));

        // -------------------------
        // Final decision
        // -------------------------
        return [
            'score' => min($score, 100),
            'reasons' => $reasons,
            'decision' => $this->decide($score),
        ];
    }

    /**
     * Detect suspicious user agents
     */
    private function isSuspiciousUserAgent(string $ua): bool
    {
        $ua = strtolower($ua);

        return str_contains($ua, 'bot')
            || str_contains($ua, 'crawler')
            || str_contains($ua, 'spider')
            || str_contains($ua, 'headless')
            || str_contains($ua, 'python')
            || str_contains($ua, 'curl')
            || str_contains($ua, 'wget');
    }

    /**
     * Convert score into decision
     */
    private function decide(int $score): string
    {
        return match (true) {
            $score <= 30 => 'allow',
            $score <= 70 => 'review',
            default => 'block',
        };
    }
}
