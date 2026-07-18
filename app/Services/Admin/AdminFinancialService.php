<?php

namespace App\Services\Admin;

use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdminFinancialService
{
    /**
     * approve ANY transaction safely
     */
    public function approve(WalletTransaction $tx): void
    {
        if ($tx->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($tx) {

            match ($tx->type) {

                'topup' => $this->approveTopUp($tx),

                'earning',
                'campaign_charge',
                'platform_fee' => $this->approveLedgerTransaction($tx),

                default => throw new InvalidArgumentException(
                    "Unsupported transaction type: {$tx->type}"
                ),
            };
        });
    }

    /**
     * TopUp approval
     */
    private function approveTopUp(WalletTransaction $tx): void
    {
        $tx->update([
            'status' => 'approved',
        ]);

        // future: notify wallet projection engine
    }

    /**
     * Ledger-based financial transactions
     */
    private function approveLedgerTransaction(WalletTransaction $tx): void
    {
        $tx->update([
            'status' => 'approved',
        ]);

        // IMPORTANT:
        // No balance mutation here.
        // Balance is computed from approved ledger only.
    }

    /**
     * Reject transaction
     */
    public function reject(WalletTransaction $tx): void
    {
        if ($tx->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($tx) {

            $tx->update([
                'status' => 'rejected',
            ]);
        });
    }
}