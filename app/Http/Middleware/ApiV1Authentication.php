<?php

namespace App\Http\Middleware;

use App\Models\ApiIntegration;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1Authentication
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $apiKey = $request->header('X-API-Key');
        $apiSecret = $request->header('X-API-Secret');

        if (!$apiKey || !$apiSecret) {
            return response()->json([
                'success' => false,
                'message' => 'API credentials are required.',
            ], 401);
        }

        $integration = ApiIntegration::where(
            'api_key',
            $apiKey
        )->first();

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials.',
            ], 401);
        }

        if (!$integration->isApproved()) {
            return response()->json([
                'success' => false,
                'message' => 'Integration is not approved.',
            ], 403);
        }

        if (
            !hash_equals(
                $integration->api_secret_hash,
                hash('sha256', $apiSecret)
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials.',
            ], 401);
        }

        $integration->forceFill([
            'last_used_at' => now(),
        ])->save();

        $request->attributes->set(
            'api_integration',
            $integration
        );

        return $next($request);
    }
}
