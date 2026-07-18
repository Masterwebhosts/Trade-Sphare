<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
   public function handle($request, Closure $next, ...$roles)
{
    $user = auth()->user();

    if (!$user) {
        abort(401, 'Unauthenticated');
    }

    if (!in_array($user->role, $roles)) {
        abort(403, 'Unauthorized role');
    }

    return $next($request);
}
}
