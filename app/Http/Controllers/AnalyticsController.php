<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    public function index(AnalyticsService $analytics)
    {
        return view('analytics.index', [
            'clicks' => $analytics->clicks(),
            'impressions' => $analytics->impressions(),
            'ctr' => $analytics->ctr(),
            'revenue' => $analytics->revenue(),
            'clicksByDay' => $analytics->clicksByDay(),
            'impressionsByDay' => $analytics->impressionsByDay(),
        ]);
    }
}
