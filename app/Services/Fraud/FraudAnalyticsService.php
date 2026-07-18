<?php

namespace App\Services\Fraud;

use App\Models\Click;

class FraudAnalyticsService
{
    /**
     * Total suspicious clicks.
     */
    public function totalSuspiciousClicks(): int
    {
        return Click::where('is_suspicious', true)->count();
    }

    /**
     * Global fraud rate (%).
     */
    public function fraudRate(): float
    {
        $totalClicks = Click::count();

        if ($totalClicks === 0) {
            return 0;
        }

        $suspiciousClicks = $this->totalSuspiciousClicks();

        return round(($suspiciousClicks / $totalClicks) * 100, 2);
    }

    /**
     * Average fraud score.
     */
    public function averageFraudScore(): float
    {
        return round(
            (float) Click::avg('fraud_score'),
            2
        );
    }

    /**
     * Top suspicious zones.
     */
    public function topSuspiciousZones(int $limit = 10)
    {
        return Click::select('ad_zone_id')
            ->selectRaw('COUNT(*) as suspicious_clicks')
            ->where('is_suspicious', true)
            ->whereNotNull('ad_zone_id')
            ->groupBy('ad_zone_id')
            ->orderByDesc('suspicious_clicks')
            ->limit($limit)
            ->get();
    }

    /**
     * Top suspicious publishers.
     */
    public function topSuspiciousPublishers(int $limit = 10)
    {
        return Click::select('publisher_id')
            ->selectRaw('COUNT(*) as suspicious_clicks')
            ->where('is_suspicious', true)
            ->whereNotNull('publisher_id')
            ->groupBy('publisher_id')
            ->orderByDesc('suspicious_clicks')
            ->limit($limit)
            ->get();
    }

    /**
     * Full dashboard payload.
     */
    public function dashboard(): array
    {
        return [
            'total_suspicious_clicks' => $this->totalSuspiciousClicks(),
            'fraud_rate'              => $this->fraudRate(),
            'average_fraud_score'     => $this->averageFraudScore(),
            'top_zones'               => $this->topSuspiciousZones(),
            'top_publishers'          => $this->topSuspiciousPublishers(),
        ];
    }
}