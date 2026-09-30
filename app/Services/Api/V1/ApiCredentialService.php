<?php

namespace App\Http\Middleware;

use App\Services\Api\V1\ApiCredentialService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1Authentication
{
    public function __construct(
        protected ApiCredentialService $credentials
    ) {
    }

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

        $integration = $this->credentials->findByApiKey($apiKey);

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials.',
            ], 401);
        }

        if (!$this->credentials->isUsable($integration)) {
            return response()->json([
                'success' => false,
                'message' => 'Integration is not approved.',
            ], 403);
        }

        if (!$this->credentials->verifySecret(
            $apiSecret,
            $integration
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API credentials.',
            ], 401);
        }

        $this->credentials->touch($integration);

        $request->attributes->set(
            'api_integration',
            $integration
        );

        return $next($request);
    }
}


