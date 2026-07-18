<?php

namespace App\Services\Billing;

use App\Models\Campaign;
use App\Models\WalletTransaction;

class BudgetEngineService
{
    /**
     * Guard spend (ledger-based ONLY)
     */
    public function guardSpend(Campaign $campaign, float $amount): bool
    {
        if ($amount <= 0) {
            return false;
        }

        if (!$campaign->isActive()) {
            return false;
        }

        $spent = (float) WalletTransaction::query()
            ->where('type', WalletTransaction::TYPE_CAMPAIGN_CHARGE)
            ->where('reference_type', 'click')
            ->sum('amount');

        $remaining = max(0, (float) $campaign->budget_total - $spent);

        return $remaining >= $amount;
    }

    /**
     * Remaining budget (ledger-based ONLY)
     */
    public function remainingBudget(Campaign $campaign): float
    {
        $spent = (float) WalletTransaction::query()
            ->where('type', WalletTransaction::TYPE_CAMPAIGN_CHARGE)
            ->where('reference_type', 'click')
            ->sum('amount');

        return max(0, (float) $campaign->budget_total - $spent);
    }
}