<?php

namespace App\Services\Finance;

use App\Models\WalletTransaction;
use App\Models\Campaign;

class FinancialService
{
    /*
    |----------------------------------------
    | CAMPAIGN SPEND (SINGLE SOURCE)
    |----------------------------------------
    */
    public function campaignSpent(int $campaignId): float
    {
        return (float) WalletTransaction::query()
            ->where('type', WalletTransaction::TYPE_CAMPAIGN_CHARGE)
            ->where('reference_type', 'click')
            ->whereJsonContains('meta->campaign_id', $campaignId)
            ->sum('amount');
    }

    /*
    |----------------------------------------
    | CAMPAIGN REMAINING BUDGET
    |----------------------------------------
    */
    public function remainingBudget(Campaign $campaign): float
    {
        $spent = $this->campaignSpent($campaign->id);

        return max(0, (float) $campaign->budget_total - $spent);
    }

    /*
    |----------------------------------------
    | TOTAL SYSTEM SPEND
    |----------------------------------------
    */
    public function totalSpend(): float
    {
        return (float) WalletTransaction::query()
            ->where('type', WalletTransaction::TYPE_CAMPAIGN_CHARGE)
            ->sum('amount');
    }

    /*
    |----------------------------------------
    | TOTAL SYSTEM EARNINGS
    |----------------------------------------
    */
    public function totalEarnings(): float
    {
        return (float) WalletTransaction::query()
            ->where('type', WalletTransaction::TYPE_EARNING)
            ->sum('amount');
    }
}