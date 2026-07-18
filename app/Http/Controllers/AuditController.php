<?php

namespace App\Http\Controllers;

use App\Services\AuditService;

class AuditController extends Controller
{
    public function index()
    {
        $result = app(AuditService::class)->fullAudit();

        return response()->json($result);
    }
}
