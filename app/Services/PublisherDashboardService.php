<?php

namespace App\Services;

use App\Models\Click;
use App\Models\Ad;
use App\Models\AdZone;
use App\Models\WalletTransaction;
use Carbon\Carbon;

class PublisherDashboardService
{
    public function getDashboardData($publisherId)
    {
        /*
        |----------------------------------
        | BASE FILTERS (SAFE)
        |----------------------------------
        */
        $clicksQuery = Click::where('publisher_id', $publisherId);

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        /*
        |----------------------------------
        | CLICKS
        |----------------------------------
        */
        $totalClicks = (clone $clicksQuery)->count();

        $todayClicks = (clone $clicksQuery)
            ->whereDate('created_at', $today)
            ->count();

        /*
        |----------------------------------
        | EARNINGS
        |----------------------------------
        */
        $earningsQuery = WalletTransaction::query()
    ->join('wallets', 'wallets.id', '=', 'wallet_transactions.wallet_id')
    ->where('wallets.owner_id', $publisherId)
    ->where('wallets.owner_type', \App\Models\Publisher::class)
    ->where('wallet_transactions.type', 'earning');
        /*
        |----------------------------------
        | EPC
        |----------------------------------
        */
        $epc = $totalClicks > 0
            ? $totalEarnings / $totalClicks
            : 0;

        /*
        |----------------------------------
        | TOP ZONES (SAFE RESOLUTION)
        |----------------------------------
        */
        $topZones = Click::select('ad_zone_id')
            ->selectRaw('COUNT(*) as clicks')
            ->where(function ($q) use ($publisherId) {
                $q->where('publisher_id', $publisherId)
                  ->orWhereHas('adZone', function ($z) use ($publisherId) {
                      $z->where('publisher_id', $publisherId);
                  });
            })
            ->whereNotNull('ad_zone_id')
            ->groupBy('ad_zone_id')
            ->orderByDesc('clicks')
            ->limit(5)
            ->get();

        /*
        |----------------------------------
        | TOP ADS (SAFE RESOLUTION)
        |----------------------------------
        */
        $topAds = Click::select('ad_id')
            ->selectRaw('COUNT(*) as clicks')
            ->where(function ($q) use ($publisherId) {
                $q->where('publisher_id', $publisherId)
                  ->orWhereHas('adZone', function ($z) use ($publisherId) {
                      $z->where('publisher_id', $publisherId);
                  });
            })
            ->groupBy('ad_id')
            ->orderByDesc('clicks')
            ->limit(5)
            ->get();

        /*
        |----------------------------------
        | RETURN DATA
        |----------------------------------
        */
        return [
            'today_earnings'      => $todayEarnings,
            'yesterday_earnings'  => $yesterdayEarnings,
            'total_earnings'      => $totalEarnings,

            'epc'                 => round($epc, 4),

            'total_clicks'        => $totalClicks,
            'today_clicks'        => $todayClicks,

            'top_zones'           => $topZones,
            'top_ads'             => $topAds,
        ];
    }
}