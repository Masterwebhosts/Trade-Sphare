<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ad;
use App\Models\Campaign;
use App\Models\Click;
use App\Models\Impression;
use App\Models\WalletTransaction;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =========================
        // USERS STATS
        // =========================
        $users = User::count();
        $advertisers = User::where('role', 'advertiser')->count();
        $publishers = User::where('role', 'publisher')->count();

        // =========================
        // ADS & CAMPAIGNS
        // =========================
        $campaigns = Campaign::count();
        $ads = Ad::count();

        // =========================
        // TRAFFIC STATS
        // =========================
        $validClicks = Click::where('is_fraud', 0)->count();
        $fraudClicks = Click::where('is_fraud', 1)->count();

        $totalClicks = $validClicks + $fraudClicks;

        $impressions = Impression::count();

        $ctr = $impressions > 0
            ? round(($validClicks / $impressions) * 100, 2)
            : 0;

        // =========================
        // FINANCIAL STATS (LEDGER)
        // =========================

        // كل ما تم خصمه من المعلنين
        $totalSpend = WalletTransaction::where('type', 'campaign_charge')
            ->sum('amount');

        // أرباح الناشرين + عمولة المنصة
        $totalEarnings = WalletTransaction::whereIn('type', [
                'earning',
                'platform_fee'
            ])
            ->sum('amount');

        // =========================
        // RETURN VIEW
        // =========================
        return view('admin.dashboard.index', [
            'users' => $users,
            'advertisers' => $advertisers,
            'publishers' => $publishers,

            'campaigns' => $campaigns,
            'ads' => $ads,

            'clicks' => $totalClicks,
            'validClicks' => $validClicks,
            'fraudClicks' => $fraudClicks,

            'impressions' => $impressions,
            'ctr' => $ctr,

            'total_spend' => $totalSpend,
            'total_earnings' => $totalEarnings,
        ]);
    }
}