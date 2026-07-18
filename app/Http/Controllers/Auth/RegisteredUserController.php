<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * عرض صفحة التسجيل
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * تنفيذ التسجيل
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $role = $request->role;

        // حماية من أي role غير مسموح
        if (!in_array($role, ['advertiser', 'publisher'])) {
            $role = 'publisher';
        }

        $user = DB::transaction(function () use ($request, $role) {

            // إنشاء المستخدم
            $user = User::create([
                'name'           => $request->name,
                'email'          => strtolower($request->email),
                'password_hash'  => Hash::make($request->password),
                'role'           => $role,
                'status'         => 'active',
            ]);

            // إنشاء المحفظة (Minimal schema فقط)
            Wallet::firstOrCreate([
                'owner_id'   => $user->id,
                'owner_type' => User::class,
            ]);

            return $user;
        });

        // حدث التسجيل
        event(new Registered($user));

        // تسجيل دخول تلقائي
        Auth::login($user);

        // توجيه حسب الدور
        return match ($user->role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'advertiser' => redirect()->route('advertiser.dashboard'),
            'publisher'  => redirect()->route('publisher.dashboard'),
            default      => redirect()->route('dashboard'),
        };
    }
}