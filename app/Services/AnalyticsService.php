<?php

namespace App\Services;

use App\Models\Impression;
use App\Models\Click;
use App\Models\Campaign;
use App\Models\Ad;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /*
    |--------------------------------------
    | CORE CTR CALC
    |--------------------------------------
    */
    private function calcCtr(int $impressions, int $clicks): float
    {
        if ($impressions <= 0) {
            return 0.0;
        }

        return round(($clicks / $impressions) * 100, 2);
    }


    /*
    |--------------------------------------
    | ADMIN STATS
    |--------------------------------------
    */
    public function getAdminStats(): array
    {
        $impressions = Impression::count();
        $clicks = Click::count();

        return [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $this->calcCtr($impressions, $clicks),

            'campaigns' => Campaign::count(),
            'ads' => Ad::count(),

            'revenue' => $this->getPlatformRevenue(),
        ];
    }


    /*
    |--------------------------------------
    | PLATFORM REVENUE
    |--------------------------------------
    */
    public function getPlatformRevenue(): float
    {
        return (float) WalletTransaction::query()
            ->where(
                'type',
                WalletTransaction::TYPE_PLATFORM_FEE
            )
            ->where(
                'status',
                WalletTransaction::STATUS_APPROVED
            )
            ->sum('amount');
    }


    /*
    |--------------------------------------
    | PUBLISHER STATS
    |--------------------------------------
    */
    public function getPublisherStats(int $publisherId): array
    {
        $impressions = Impression::where(
            'publisher_id',
            $publisherId
        )->count();


        $clicks = Click::where(
            'publisher_id',
            $publisherId
        )->count();


        return [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $this->calcCtr($impressions, $clicks),
            'revenue' => $this->getPublisherRevenue($publisherId),
        ];
    }


    /*
    |--------------------------------------
    | PUBLISHER REVENUE
    |--------------------------------------
    */
    public function getPublisherRevenue(int $publisherId): float
    {
        return (float) WalletTransaction::query()
            ->join(
                'wallets',
                'wallets.id',
                '=',
                'wallet_transactions.wallet_id'
            )
            ->where(
                'wallets.owner_id',
                $publisherId
            )
            ->where(
                'wallets.owner_type',
                \App\Models\User::class
            )
            ->where(
                'wallet_transactions.type',
                WalletTransaction::TYPE_EARNING
            )
            ->where(
                'wallet_transactions.status',
                WalletTransaction::STATUS_APPROVED
            )
            ->sum('wallet_transactions.amount');
    }


    /*
    |--------------------------------------
    | CAMPAIGN STATS
    |--------------------------------------
    */
    public function getCampaignStats(int $campaignId): array
    {
        $impressions = Impression::where(
            'campaign_id',
            $campaignId
        )->count();


        $clicks = Click::whereHas(
            'ad',
            function ($query) use ($campaignId) {

                $query->where(
                    'campaign_id',
                    $campaignId
                );

            }
        )->count();


        return [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $this->calcCtr($impressions, $clicks),
        ];
    }


    /*
    |--------------------------------------
    | ZONE STATS
    |--------------------------------------
    */
    public function getZoneStats(int $zoneId): array
    {
        $impressions = Impression::where(
            'zone_id',
            $zoneId
        )->count();


        $clicks = Click::where(
            'zone_id',
            $zoneId
        )->count();


        return [
            'impressions' => $impressions,
            'clicks' => $clicks,
            'ctr' => $this->calcCtr($impressions, $clicks),
        ];
    }


    /*
    |--------------------------------------
    | GLOBAL CTR
    |--------------------------------------
    */
    public function getGlobalCTR(): float
    {
        return $this->calcCtr(
            Impression::count(),
            Click::count()
        );
    }


    /*
    |--------------------------------------
    | TODAY STATS
    |--------------------------------------
    */
    public function getTodayStats(): array
    {
        return [
            'impressions' => DB::table('impressions')
                ->whereDate('created_at', today())
                ->count(),

            'clicks' => DB::table('clicks')
                ->whereDate('created_at', today())
                ->count(),

            'campaigns' => DB::table('campaigns')
                ->count(),

            'ads' => DB::table('ads')
                ->count(),
        ];
    }
}