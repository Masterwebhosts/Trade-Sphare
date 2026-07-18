<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use App\Services\Admin\AdminFinancialService;

class TopUpApprovalController extends Controller
{
    public function __construct(
        protected AdminFinancialService $service
    ) {}

    public function index()
    {
        $topups = WalletTransaction::where('type', 'topup')
    ->latest()
    ->get();

        return view('admin.topups.index', compact('topups'));
    }

    public function show(WalletTransaction $tx)
{
    return view('admin.topups.show', [
        'topup' => $tx
    ]);
}

    public function approve(WalletTransaction $tx)
    {
        // 🔒 حماية إضافية
        if ($tx->type !== 'topup' || $tx->status !== 'pending') {
            return back()->withErrors(['error' => 'Invalid transaction']);
        }

       $this->service->approve($tx);

        return back()->with('success', 'Topup approved');
    }

    public function reject(WalletTransaction $tx)
    {
        if ($tx->type !== 'topup' || $tx->status !== 'pending') {
            return back()->withErrors(['error' => 'Invalid transaction']);
        }

        $this->service->reject($tx);

        return back()->with('success', 'Topup rejected');
    }
}