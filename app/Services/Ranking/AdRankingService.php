<?php

namespace App\Services\Ranking;

use App\Models\Ad;

class AdRankingService
{
    /**
     * ONLY USED IN BACKGROUND CACHE BUILDING
     */
    public function buildScore(Ad $ad): float
    {
        $campaign = $ad->campaign;

        if (!$campaign) return 0;

        $ctr = $this->ctr($ad);

        $bid = (float) $campaign->bid_amount;
        $priority = (float) ($campaign->priority ?? 1);

        $budgetFactor = $this->budgetFactor($campaign);
        $pacingFactor = $this->pacingFactor($campaign);

        $impressions = max($ad->impressions_count ?? 1, 1);
        $frequencyPenalty = log($impressions);

        return
            ($ctr * 120) +
            ($bid * 2.2) +
            ($priority * 25) +
            ($budgetFactor * 40) +
            ($pacingFactor * 45) -
            ($frequencyPenalty * 35);
    }

    protected function ctr(Ad $ad): float
    {
        $imp = max($ad->impressions_count ?? 0, 1);
        $clk = $ad->clicks_count ?? 0;

        $baseCTR = 0.02;
        $k = 100;

        return ($clk + $baseCTR * $k) / ($imp + $k);
    }

    protected function budgetFactor($campaign): float
    {
        $total = (float) $campaign->budget_total;
        if ($total <= 0) return 0;

        $spent = (float) $campaign->budget_spent;

        $r = $spent / $total;

        return match (true) {
            $r < 0.5 => 1.2,
            $r < 0.8 => 1.0,
            $r < 1.0 => 0.7,
            default => 0.3,
        };
    }

    protected function pacingFactor($campaign): float
    {
        $total = (float) $campaign->budget_total;
        if ($total <= 0) return 1;

        $spent = (float) $campaign->budget_spent;

        $progress = now()->hour / 24;
        $expected = $total * $progress;

        if ($expected <= 0) return 1;

        $r = $spent / $expected;

        return match (true) {
            $r < 0.7 => 1.3,
            $r < 1.0 => 1.0,
            $r < 1.3 => 0.7,
            default => 0.4,
        };
    }
}
