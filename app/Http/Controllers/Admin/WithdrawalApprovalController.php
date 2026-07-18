<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WithdrawalApprovalController extends Controller
{
    public function approve(Withdrawal $withdrawal)
    {
        return DB::transaction(function () use ($withdrawal) {

            $withdrawal = Withdrawal::where('id', $withdrawal->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($withdrawal->status !== 'pending') {
                return back()->withErrors(['status' => 'Not pending']);
            }

            // 💰 خصم من المحفظة (ledger)
            WalletTransaction::create([
                'wallet_id' => $withdrawal->wallet_id,
                'type'      => 'withdrawal',
                'amount'    => $withdrawal->amount,
                'direction' => 'debit',
                'status'    => 'approved',
                'reference_type' => 'withdrawal',
                'reference_id'   => $withdrawal->id,
                'meta' => json_encode([
                    'approved_by' => auth()->id(),
                ]),
            ]);

            $withdrawal->update([
                'status'       => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            return back()->with('success', 'Withdrawal approved');
        });
    }

    public function reject(Withdrawal $withdrawal)
    {
        return DB::transaction(function () use ($withdrawal) {

            $withdrawal = Withdrawal::where('id', $withdrawal->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($withdrawal->status !== 'pending') {
                return back()->withErrors(['status' => 'Not pending']);
            }

            $withdrawal->update([
                'status'       => 'rejected',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            return back()->with('success', 'Withdrawal rejected');
        });
    }
}