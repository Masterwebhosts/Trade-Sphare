<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Models\User;
use App\Models\Campaign;
use App\Models\Ad;

class AnalyticsController extends Controller
{
    public function index(AnalyticsService $analytics)
    {
        $stats = $analytics->getTodayStats();

        $users = User::count();
        $campaigns = Campaign::count();
        $ads = Ad::count();

        return view('admin.analytics.index', [
            'users' => $users,
            'campaigns' => $campaigns,
            'ads' => $ads,

            // مهم جداً (Fix الخطأ)
            'clicks' => $stats['clicks'] ?? 0,
            'impressions' => $stats['impressions'] ?? 0,
            'ctr' => $stats['ctr'] ?? 0,
        ]);
    }
}
