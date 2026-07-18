<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Services\PublisherStatsService;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function __construct(
        protected PublisherStatsService $statsService
    ) {}

    /**
     * Publisher stats API endpoint
     */
    public function index(Request $request)
    {
        $publisherId = $request->user()->id;

        $stats = $this->statsService->getDashboardStats($publisherId);

        return response()->json([
            'success' => true,
            'data'    => $stats,
        ]);
    }
}