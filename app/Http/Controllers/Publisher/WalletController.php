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
        | SUMMARY
        |------------------------------------
        */

        $totalEarnings = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('amount', '>', 0)
            ->sum('amount');


        $todayEarnings = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('amount', '>', 0)
            ->whereDate('created_at', today())
            ->sum('amount');


        $totalClicks = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('reference_type', 'click')
            ->count();


        $epc = $totalClicks > 0
            ? $totalEarnings / $totalClicks
            : 0;



        $summary = [

            'total_earnings' => (float) $totalEarnings,

            'today_earnings' => (float) $todayEarnings,

            'total_clicks' => $totalClicks,

            'epc' => $epc,

        ];



        /*
        |------------------------------------
        | RETURN VIEW
        |------------------------------------
        */

        return view('publisher.wallet.index', [

            'wallet' => $wallet,

            'balance' => $balance,

            'transactions' => $transactions,

            'summary' => $summary,

        ]);

    }
}