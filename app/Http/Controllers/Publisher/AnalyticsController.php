<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function chart(Request $request)
    {
        return response()->json([
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            'data' => [12, 19, 7, 15, 22],
        ]);
    }
}
