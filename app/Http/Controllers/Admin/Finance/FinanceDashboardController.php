<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class FinanceDashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalTopUps = WalletTransaction::where('type', WalletTransaction::TYPE_TOPUP)
            ->where('status', WalletTransaction::STATUS_APPROVED)
            ->where('direction', WalletTransaction::DIRECTION_CREDIT)
            ->sum('amount');

        $totalWithdrawals = Withdrawal::whereIn('status', [
                'approved',
                'paid',
            ])
            ->sum('amount');

        $platformRevenue = WalletTransaction::where('type', WalletTransaction::TYPE_PLATFORM_FEE)
            ->where('status', WalletTransaction::STATUS_APPROVED)
            ->sum('amount');

        $totalTransactions = WalletTransaction::count();

        $pendingTopups = WalletTransaction::where('type', WalletTransaction::TYPE_TOPUP)
            ->where('status', WalletTransaction::STATUS_PENDING)
            ->count();

        $pendingWithdrawals = Withdrawal::where('status', 'pending')
            ->count();

        return view('admin.finance.dashboard', compact(
            'totalTopUps',
            'totalWithdrawals',
            'platformRevenue',
            'totalTransactions',
            'pendingTopups',
            'pendingWithdrawals'
        ));
    }
}