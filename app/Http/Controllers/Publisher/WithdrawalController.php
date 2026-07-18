<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    /**
     * عرض صفحة طلبات السحب
     */
    public function index()
    {
        $user = auth()->user();

        $wallet = $user->wallet;

        if (!$wallet) {
            return view('publisher.withdrawals.index', [
                'withdrawals' => collect(),
                'balance' => 0,
            ]);
        }

        return view('publisher.withdrawals.index', [
            'withdrawals' => Withdrawal::where('wallet_id', $wallet->id)
                ->latest()
                ->get(),

            'balance' => $wallet->balance ?? 0,
        ]);
    }

    /**
     * إنشاء طلب سحب
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $wallet = $user->wallet;

        if (!$wallet) {
            return back()->with('error', 'Wallet not found');
        }

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:10'],
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email'],
            'phone'  => ['required', 'string', 'max:30'],
            'method' => ['required', 'in:bank,wallet'],
        ]);

        if ($wallet->balance < $data['amount']) {
            return back()->with('error', 'Insufficient balance');
        }

        Withdrawal::create([
            'wallet_id' => $wallet->id,
            'amount'    => $data['amount'],
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'method'    => $data['method'],
            'status'    => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request created successfully');
    }
}