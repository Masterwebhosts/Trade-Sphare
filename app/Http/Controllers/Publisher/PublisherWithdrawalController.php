<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Services\Ledger\LedgerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublisherWithdrawalController extends Controller
{
    public function __construct(
        protected LedgerService $ledgerService
    ) {}

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $user = auth()->user();

        return DB::transaction(function () use ($request, $user) {

            $wallet = Wallet::where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                abort(404, 'Wallet not found');
            }

            $amount = (float) $request->amount;

            // 🔴 Minimum withdrawal rule
            if ($amount < 10) {
                return back()->withErrors([
                    'amount' => 'الحد الأدنى للسحب هو 10$'
                ]);
            }

            // 🔵 Calculate real balance from ledger
            $balance = WalletTransaction::where('wallet_id', $wallet->id)
                ->selectRaw("SUM(CASE WHEN type='credit' THEN amount ELSE -amount END) as balance")
                ->value('balance') ?? 0;

            if ($balance < $amount) {
                return back()->withErrors([
                    'amount' => 'رصيد غير كافي للسحب'
                ]);
            }

            // 🧾 Create withdrawal request
            $withdrawal = Withdrawal::create([
                'user_id'   => $user->id,
                'user_type' => get_class($user),
                'amount'    => $amount,
                'status'    => 'pending',
            ]);

            // 📒 Ledger entry
            $this->ledgerService->record(
                account: $user,
                type: 'DEBIT',
                amount: $amount,
                refId: $withdrawal->id,
                reference: 'withdrawal_hold_' . $withdrawal->id,
                meta: [
                    'action' => 'withdrawal_request',
                    'status' => 'pending'
                ]
            );

            return back()->with('success', 'Withdrawal request submitted successfully');
        });
    }
}
