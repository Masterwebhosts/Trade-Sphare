<?php

namespace App\Http\Controllers\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Click;
use App\Models\Impression;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        /*
        |------------------------------------------------
        | CAMPAIGNS
        |------------------------------------------------
        */
        $campaigns = Campaign::query()
            ->where('advertiser_id', $userId)
            ->get();

        $campaignIds = $campaigns->pluck('id');

        /*
        |------------------------------------------------
        | IMPRESSIONS
        |------------------------------------------------
        */
        $impressionCounts = Impression::query()
            ->select('ads.campaign_id', DB::raw('COUNT(*) as total'))
            ->join('ads', 'ads.id', '=', 'impressions.ad_id')
            ->whereIn('ads.campaign_id', $campaignIds)
            ->groupBy('ads.campaign_id')
            ->pluck('total', 'campaign_id');

        /*
        |------------------------------------------------
        | CLICKS
        |------------------------------------------------
        */
        $clickCounts = Click::query()
            ->select('ads.campaign_id', DB::raw('COUNT(*) as total'))
            ->join('ads', 'ads.id', '=', 'clicks.ad_id')
            ->whereIn('ads.campaign_id', $campaignIds)
            ->groupBy('ads.campaign_id')
            ->pluck('total', 'campaign_id');

        /*
        |------------------------------------------------
        | BUILD STATS
        |------------------------------------------------
        */
        $campaignStats = $campaigns->map(function ($campaign) use (
            $impressionCounts,
            $clickCounts
        ) {
            $impressions = (int) ($impressionCounts[$campaign->id] ?? 0);
            $clicks = (int) ($clickCounts[$campaign->id] ?? 0);

            $ctr = $impressions > 0
                ? round(($clicks / $impressions) * 100, 2)
                : 0;

            return [
                'id'          => $campaign->id,
                'name'        => $campaign->name,
                'status'      => $campaign->status,
                'impressions' => $impressions,
                'clicks'      => $clicks,
                'ctr'         => $ctr,
            ];
        });

        $totalImpressions = $campaignStats->sum('impressions');
        $totalClicks = $campaignStats->sum('clicks');

        $totalCtr = $totalImpressions > 0
            ? round(($totalClicks / $totalImpressions) * 100, 2)
            : 0;

        return view('advertiser.stats.index', [
            'campaignStats' => $campaignStats,
            'impressions'   => $totalImpressions,
            'clicks'        => $totalClicks,
            'ctr'           => $totalCtr,
        ]);
    }
}