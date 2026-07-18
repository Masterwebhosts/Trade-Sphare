<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Wallet\WalletService;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function index(Request $request, WalletService $walletService)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        /*
        |------------------------------------
        | WALLET RESOLUTION
        |------------------------------------
        */
        $wallet = WalletService::resolve($user);

        /*
        |------------------------------------
        | TRANSACTIONS
        |------------------------------------
        */
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->latest()
            ->paginate(20);

        /*
        |------------------------------------
        | BALANCE
        |------------------------------------
        */
        $balance = $wallet->balance;

        /*
        |------------------------------------
        | SUMMARY (OPTIMIZED)
        |------------------------------------
        */
        $summaryData = WalletTransaction::where('wallet_id', $wallet->id)
            ->selectRaw("
                SUM(CASE WHEN type = 'earning' THEN amount ELSE 0 END) as total_earnings,
                SUM(CASE WHEN type = 'platform_fee' THEN amount ELSE 0 END) as total_fees,
                SUM(CASE WHEN type = 'campaign_charge' THEN amount ELSE 0 END) as total_campaign_charges
            ")
            ->first();

        $summary = [
            'total_earnings'        => (float) $summaryData->total_earnings,
            'total_fees'            => (float) $summaryData->total_fees,
            'total_campaign_charges'=> (float) $summaryData->total_campaign_charges,
        ];

        return view('publisher.wallet.index', [
            'wallet'       => $wallet,
            'balance'      => $balance,
            'transactions' => $transactions,
            'summary'      => $summary,
        ]);
    }
}