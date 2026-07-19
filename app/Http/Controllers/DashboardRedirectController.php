<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardRedirectController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'advertiser' => redirect()->route('advertiser.dashboard'),
            'publisher' => redirect()->route('publisher.dashboard'),
            default => abort(403),
        };
    }
}
