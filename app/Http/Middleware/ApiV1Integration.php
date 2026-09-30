<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1Integration
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $integration = $request->attributes->get(
            'api_integration'
        );

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'Integration authentication required.',
            ], 401);
        }

        if ($integration->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'API integration is not approved.',
            ], 403);
        }

        if (
            is_array($integration->allowed_ips)
            && count($integration->allowed_ips) > 0
            && !in_array(
                $request->ip(),
                $integration->allowed_ips,
                true
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'IP address is not allowed.',
            ], 403);
        }

        $integration->forceFill([
            'last_used_at' => now(),
        ])->save();

        return $next($request);
    }
}
