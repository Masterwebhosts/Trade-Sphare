<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use App\Models\Campaign;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboard)
    {
        $userId = Auth::id();

        // 📊 Stats من Service فقط
        $stats = $dashboard->advertiser($userId);

        // 📦 الحملات (مربوطة بالمستخدم)
        $campaigns = Campaign::where('advertiser_id', $userId)
        ->latest()
        ->get();

        // 📦 الإعلانات (عبر الحملات الخاصة بالمستخدم)
        $ads = Ad::with('campaign')
        ->whereHas('campaign', function ($q) use ($userId) {
        $q->where('advertiser_id', $userId);
    })
        ->latest()
        ->get();
        return view('advertiser.dashboard.index', compact(
            'stats',
            'campaigns',
            'ads'
        ));
    }
}