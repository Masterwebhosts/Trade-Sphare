<?php

namespace App\Http\Controllers;

use App\Services\ReconciliationService;

class ReconciliationController extends Controller
{
    public function run()
    {
        $result = app(ReconciliationService::class)->runFull();

        return response()->json($result);
    }
}
