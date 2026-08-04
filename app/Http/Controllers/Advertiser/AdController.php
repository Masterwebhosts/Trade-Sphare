<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Campaign;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdController extends Controller
{

    public function index()
    {

        $ads = Ad::with('campaign')
    ->withCount([
        'impressions',
        'clicks'
    ])
    ->whereHas('campaign', function ($query) {

        $query->where(
            'advertiser_id',
            auth()->id()
        );

    })
    ->latest()
    ->paginate(10);

        return view(
            'advertiser.ads.index',
            compact('ads')
        );
    }

    public function create()
    {

        $campaigns = Campaign::where(
                'advertiser_id',
                auth()->id()
            )
            ->latest()
            ->get();



        $wallet = Wallet::forUser(
            auth()->user()
        );


        $balance = $wallet?->balance ?? 0;



        return view(
            'advertiser.ads.create',
            compact(
                'campaigns',
                'wallet',
                'balance'
            )
        );
    }

    public function store(Request $request)
    {


        $data = $request->validate([


            'campaign_id' => [
                'required',
                'exists:campaigns,id'
            ],


            'title' => [
                'required',
                'string',
                'max:255'
            ],


            'description' => [
                'nullable',
                'string'
            ],


            'content_type' => [
                'required',
                'string',
                'max:30'
            ],


            'media_url' => [
                'nullable',
                'url'
            ],


            'target_url' => [
                'required',
                'url'
            ],


        ]);

        $campaign = Campaign::where('id', $data['campaign_id'])
            ->where(
                'advertiser_id',
                auth()->id()
            )
            ->firstOrFail();

        $ad = Ad::create([


            'campaign_id' => $campaign->id,


            'title' => $data['title'],


            'description' =>
                $data['description'] ?? null,



            'content_type' =>
                $data['content_type'],



            'media_url' =>
                $data['media_url'] ?? null,



            'target_url' =>
                $data['target_url'],



            'status' => Ad::STATUS_PENDING,


        ]);

        return redirect()
            ->route('advertiser.ads.index')
            ->with(
                'success',
                'تم إنشاء الإعلان وإرساله للمراجعة'
            );
    }





    public function edit(Ad $ad)
    {

        $this->authorizeAd($ad);

        $campaigns = Campaign::where('advertiser_id', auth()->id())
          ->where('status', Campaign::STATUS_APPROVED)
          ->where('budget_remaining', '>', 0)
          ->latest()
          ->get();

        return view(
            'advertiser.ads.edit',
            compact(
                'ad',
                'campaigns'
            )
        );

    }

    public function update(Request $request, Ad $ad)
    {

        $this->authorizeAd($ad);

        $data = $request->validate([

            'campaign_id' => [
                'required',
                'exists:campaigns,id'
            ],

            'title' => [
                'required',
                'string',
                'max:255'
            ],


            'description' => [
                'nullable',
                'string'
            ],


            'content_type' => [
                'required',
                'string',
                'max:30'
            ],


            'media_url' => [
                'nullable',
                'url'
            ],


            'target_url' => [
                'required',
                'url'
            ],


        ]);

        $campaign = Campaign::where('id', $data['campaign_id'])
            ->where('advertiser_id', auth()->id())
            ->where('status', Campaign::STATUS_APPROVED)
            ->where('budget_remaining', '>', 0)
            ->firstOrFail();


        $ad->update([


            'campaign_id' => $campaign->id,


            'title' => $data['title'],


            'description' =>
                $data['description'] ?? null,


            'content_type' =>
                $data['content_type'],


            'media_url' =>
                $data['media_url'] ?? null,


            'target_url' =>
                $data['target_url'],

        ]);


        return back()
            ->with(
                'success',
                'تم تحديث الإعلان بنجاح'
            );

    }

    public function destroy(Ad $ad)
    {

        $this->authorizeAd($ad);


        $ad->delete();


        return back()
            ->with(
                'success',
                'تم حذف الإعلان بنجاح'
            );

    }

    private function authorizeAd(Ad $ad): void
    {

        abort_if(
            !$ad->campaign ||
            $ad->campaign->advertiser_id !== auth()->id(),
            403
        );

    }

}