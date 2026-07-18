<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    public function handle($request, Closure $next)
{
    $response = $next($request);

    return response()->json(
        json_decode($response->getContent(), true),
        $response->getStatusCode()
    );
}
}
