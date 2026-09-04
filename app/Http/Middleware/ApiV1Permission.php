<?php

namespace App\Http\Middleware;

use App\Services\Api\V1\ApiCredentialService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1Permission
{
    public function __construct(
        protected ApiCredentialService $credentials
    ) {
    }

    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $integration = $request->attributes->get('api_integration');

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'API integration is not authenticated.',
            ], 401);
        }

        if (!$this->credentials->hasPermission(
            $integration,
            $permission
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient API permissions.',
            ], 403);
        }

        return $next($request);
    }
}
