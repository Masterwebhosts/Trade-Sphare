<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboard)
    {
        $userId = Auth::id();

        $stats = $dashboard->publisher($userId);

        return view('publisher.dashboard.index', [
            'stats' => $stats,
        ]);
    }
}