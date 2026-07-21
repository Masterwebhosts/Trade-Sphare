<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // ✔️ المهم هنا
        $user = Auth::user();

        return match ($user->role ?? null) {
            'admin' => redirect()->route('admin.dashboard'),
            'advertiser' => redirect()->route('advertiser.dashboard'),
            'publisher' => redirect()->route('publisher.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

public function destroy(Request $request): RedirectResponse
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
