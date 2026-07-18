<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Services\Wallet\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    /**
     * عرض صفحة شحن المحفظة
     */
    public function create()
    {
        $user = auth()->user();

        abort_if(!$user, 401);

        $wallet = WalletService::resolve($user);

        return view('advertiser.wallet.topup', [
            'balance' => $wallet->balance,
        ]);
    }

    /**
     * إرسال طلب شحن
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount'         => ['required', 'numeric', 'min:10'],
            'payer_name'     => ['required', 'string', 'max:255'],
            'company_name'   => ['nullable', 'string', 'max:255'],
            'payment_method' => ['required', 'string'],
            'receipt'        => ['required', 'image', 'max:4096'],
        ]);

        $user = auth()->user();

        abort_if(!$user, 401);

        $wallet = WalletService::resolve($user);

        $receiptPath = $request->file('receipt')->store('receipts', 'public');

        DB::transaction(function () use ($wallet, $data, $receiptPath) {

            // 🔥 idempotency protection (optional but recommended)
            $exists = WalletTransaction::query()
                ->where('wallet_id', $wallet->id)
                ->where('type', WalletTransaction::TYPE_TOPUP)
                ->where('status', WalletTransaction::STATUS_PENDING)
                ->whereJsonContains('meta->receipt', $receiptPath)
                ->exists();

            if ($exists) {
                return;
            }

            WalletTransaction::create([
    'wallet_id'      => $wallet->id,
    'type'           => WalletTransaction::TYPE_TOPUP,

    // ✅ FIX REQUIRED
    'category'       => 'topup',

    'amount'         => $data['amount'],
    'direction'      => WalletTransaction::DIRECTION_CREDIT,
    'status'         => WalletTransaction::STATUS_PENDING,
    'reference_type' => 'manual_topup',
    'reference_id'   => null,

    'meta' => [
        'payer_name'     => $data['payer_name'],
        'company_name'   => $data['company_name'] ?? null,
        'payment_method' => $data['payment_method'],
        'receipt'        => $receiptPath ?? null,
    ],
]);
        });

        return redirect()
            ->route('advertiser.topup.create')
            ->with('success', 'تم إرسال طلب شحن المحفظة بنجاح، وسيتم مراجعته من الإدارة.');
    }
}