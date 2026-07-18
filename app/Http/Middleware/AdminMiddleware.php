<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (strtolower($user->role) !== 'admin') {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
