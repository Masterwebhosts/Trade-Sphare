<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;

class AdController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST ADS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $ads = Ad::with('campaign')
            ->latest()
            ->paginate(20);

        return view('admin.ads.index', compact('ads'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW AD
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $ad = Ad::with('campaign')->findOrFail($id);

        return view('admin.ads.show', compact('ad'));
    }

    /*
    |--------------------------------------------------------------------------
    | MODERATION VIEW
    |--------------------------------------------------------------------------
    */
    public function moderation($id)
    {
        $ad = Ad::with('campaign')->findOrFail($id);

        return view('admin.ads.moderation', compact('ad'));
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE AD
    |--------------------------------------------------------------------------
    */
    public function approve($id)
{
    $ad = Ad::findOrFail($id);

    // منع الاعتماد فقط إذا كان محذوف
    if ($ad->status === 'deleted') {
        return back()->with('error', 'لا يمكن اعتماد إعلان محذوف');
    }

    if ($ad->status === 'active') {
        return back()->with('info', 'الإعلان نشط مسبقاً');
    }

    $ad->update([
        'status' => 'active',
    ]);

    return back()->with('success', 'تم قبول الإعلان بنجاح');
}
    /*
    |--------------------------------------------------------------------------
    | REJECT AD
    |--------------------------------------------------------------------------
    */
    public function reject($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->status === 'rejected') {
            return back()->with('info', 'الإعلان مرفوض مسبقاً');
        }

        $ad->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'تم رفض الإعلان');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE AD (SOFT LIFECYCLE)
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $ad = Ad::findOrFail($id);

        if ($ad->status === 'deleted') {
            return back()->with('error', 'الإعلان محذوف مسبقاً');
        }

        $ad->update([
            'status' => 'deleted',
        ]);

        $ad->delete();

        return redirect()
            ->route('admin.ads.index')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }
}