<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ApiIntegration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    /**
     * Return the authenticated integration status.
     */
    public function status(Request $request): JsonResponse
    {
        /** @var ApiIntegration|null $integration */
        $integration = $request->attributes->get(
            'api_integration'
        );

        if (!$integration) {
            return response()->json([
                'success' => false,
                'message' => 'Integration not found.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $integration->id,
                'name' => $integration->name,
                'slug' => $integration->slug,
                'status' => $integration->status,
                'permissions' => $integration->permissions ?? [],
                'rate_limit' => $integration->rate_limit,
                'last_used_at' => $integration->last_used_at,
                'approved_at' => $integration->approved_at,
            ],
        ]);
    }
}
