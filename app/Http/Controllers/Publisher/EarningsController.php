<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        // 1. التأكد من المستخدم
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        // 2. جلب المحفظة الصحيحة
        $wallet = Wallet::forUser($user);

        if (!$wallet) {
            logger()->critical('Wallet not found for user', [
                'user_id' => $user->id,
                'trace' => debug_backtrace()
            ]);

            abort(500, 'Wallet not found');
        }

        // 3. جلب الأرباح
        $earnings = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->latest()
            ->paginate(15);

        // 4. المجموع
        $total = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->sum('amount');

        return view('publisher.earnings.index', [
            'earnings' => $earnings,
            'total' => $total,
        ]);
    }
}