<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->get();

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function review(Campaign $campaign)
    {
        return view('admin.campaigns.review', compact('campaign'));
    }

    /* =========================
       APPROVE
    ==========================*/
    public function approve(Campaign $campaign)
{
    if ($campaign->status === Campaign::STATUS_APPROVED) {
        return redirect()
            ->route('admin.campaigns.review', $campaign->id)
            ->with('info', 'الحملة مفعلة مسبقًا');
    }

    $campaign->update([
        'status' => Campaign::STATUS_APPROVED,
    ]);

    return redirect()
        ->route('admin.campaigns.review', $campaign->id)
        ->with('success', 'تمت الموافقة على الحملة');
}

    /* =========================
       REJECT
    ==========================*/
    public function reject(Campaign $campaign)
{
    if ($campaign->status === Campaign::STATUS_REJECTED) {
        return redirect()
            ->route('admin.campaigns.review', $campaign->id)
            ->with('info', 'الحملة مرفوضة مسبقًا');
    }

    $campaign->update([
        'status' => Campaign::STATUS_REJECTED,
    ]);

    return redirect()
        ->route('admin.campaigns.review', $campaign->id)
        ->with('success', 'تم رفض الحملة');
}
    /* =========================
       DELETE
    ==========================*/
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'تم حذف الحملة');
    }
}