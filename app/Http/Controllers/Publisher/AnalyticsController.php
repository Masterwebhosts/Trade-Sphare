<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Services\PublisherStatsService;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    public function chart(PublisherStatsService $publisherStats): JsonResponse
    {
        return response()->json(
            $publisherStats->getLast7DaysChart(auth()->id())
        );
    }
}