<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Ad;
use App\Models\Click;
use App\Models\Governorate;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
{
    $campaigns = Campaign::query()
        ->where('advertiser_id', auth()->id())
        ->latest()
        ->withCount('ads')
        ->paginate(20);

    $campaignIds = $campaigns->pluck('id');

    $adsCount = Ad::whereIn('campaign_id', $campaignIds)->count();

    $activeAds = Ad::whereIn('campaign_id', $campaignIds)
        ->where('status', 'active')
        ->count();

    $clicks = Click::whereIn('ad_id', function ($query) use ($campaignIds) {
        $query->select('id')
            ->from('ads')
            ->whereIn('campaign_id', $campaignIds);
    })->count();

    $totalSpent = WalletTransaction::query()
        ->where('type', WalletTransaction::TYPE_CAMPAIGN_CHARGE)
        ->where('direction', WalletTransaction::DIRECTION_DEBIT)
        ->where('status', WalletTransaction::STATUS_APPROVED)
        ->whereIn('meta->campaign_id', $campaignIds)
        ->sum('amount');

    return view('advertiser.campaigns.index', compact(
        'campaigns',
        'adsCount',
        'activeAds',
        'clicks',
        'totalSpent'
    ));
}


    public function create()
    {
        $governorates = Governorate::orderBy('name')
            ->get();


        return view('advertiser.campaigns.create', compact(
            'governorates'
        ));
    }





    public function store(Request $request)
    {

        $data = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],


            'description' => [
                'nullable',
                'string'
            ],


            'budget_total' => [
                'required',
                'numeric',
                'min:0.01'
            ],


            'cpc' => [
                'required',
                'numeric',
                'min:0.01'
            ],


            'start_date' => [
                'required',
                'date'
            ],


            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date'
            ],


            'governorate_id' => [
                'nullable',
                'exists:governorates,id'
            ],


        ]);




        Campaign::create([

            'advertiser_id' => auth()->id(),

            'title' => $data['name'],

            'description' => $data['description'] ?? null,


            'budget_total' => $data['budget_total'],

            'budget_spent' => 0,

            'budget_remaining' => $data['budget_total'],


            'cpc' => $data['cpc'],


            'governorate_id' => $data['governorate_id'] ?? null,


            'start_date' => $data['start_date'],

            'end_date' => $data['end_date'],


            'status' => Campaign::STATUS_PENDING,

        ]);




        return redirect()
            ->route('advertiser.campaigns.index')
            ->with(
                'success',
                'تم إنشاء الحملة الإعلانية بنجاح'
            );
    }





    public function show(Campaign $campaign)
    {
        $this->authorizeOwner($campaign);


        return view(
            'advertiser.campaigns.show',
            compact('campaign')
        );
    }





    public function edit(Campaign $campaign)
    {
        $this->authorizeOwner($campaign);



        return view(
            'advertiser.campaigns.edit',
            [

                'campaign' => $campaign,

                'governorates' => Governorate::orderBy('name')->get(),

            ]
        );
    }





    public function update(Request $request, Campaign $campaign)
    {

        $this->authorizeOwner($campaign);



        $data = $request->validate([


            'name' => [
                'required',
                'string',
                'max:255'
            ],


            'description' => [
                'nullable',
                'string'
            ],


            'budget_total' => [
                'required',
                'numeric',
                'min:0.01'
            ],


            'cpc' => [
                'required',
                'numeric',
                'min:0.01'
            ],


            'start_date' => [
                'required',
                'date'
            ],


            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date'
            ],


            'governorate_id' => [
                'nullable',
                'exists:governorates,id'
            ],


        ]);




        $campaign->update([


            'title' => $data['name'],


            'description' => $data['description'] ?? null,


            'budget_total' => $data['budget_total'],


            'budget_remaining' =>
                max(
                    0,
                    $data['budget_total'] - $campaign->budget_spent
                ),



            'cpc' => $data['cpc'],


            'governorate_id' =>
                $data['governorate_id'] ?? null,



            'start_date' => $data['start_date'],


            'end_date' => $data['end_date'],


        ]);




        return redirect()
            ->route('advertiser.campaigns.index')
            ->with(
                'success',
                'تم تحديث الحملة بنجاح'
            );
    }





    public function destroy(Campaign $campaign)
    {
        $this->authorizeOwner($campaign);


        $campaign->delete();


        return redirect()
            ->route('advertiser.campaigns.index')
            ->with(
                'success',
                'تم حذف الحملة بنجاح'
            );
    }





    private function authorizeOwner(Campaign $campaign): void
    {

        abort_if(
            $campaign->advertiser_id !== auth()->id(),
            403
        );

    }
}