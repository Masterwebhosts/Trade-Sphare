<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Click;

class FraudDashboardController extends Controller
{
    public function index()
    {
        $totalClicks = Click::count();

        $fraudClicks = Click::where('is_fraud', true)->count();

        $fraudRate = $totalClicks > 0
            ? round(($fraudClicks / $totalClicks) * 100, 2)
            : 0;


        $topIps = Click::selectRaw('ip_address as ip, COUNT(*) as clicks')
            ->where('is_fraud', true)
            ->groupBy('ip_address')
            ->orderByDesc('clicks')
            ->limit(10)
            ->get();


        $topAds = Click::selectRaw('ad_id, COUNT(*) as clicks')
            ->where('is_fraud', true)
            ->groupBy('ad_id')
            ->orderByDesc('clicks')
            ->limit(10)
            ->get();


        $recentFraud = Click::where('is_fraud', true)
            ->latest()
            ->limit(20)
            ->get();


        $scoreBuckets = [];


        return view('admin.fraud.index', compact(
            'totalClicks',
            'fraudClicks',
            'fraudRate',
            'scoreBuckets',
            'topIps',
            'topAds',
            'recentFraud'
        ));
    }
}