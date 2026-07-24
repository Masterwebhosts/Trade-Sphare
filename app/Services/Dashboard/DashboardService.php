<?php

namespace App\Services\Dashboard;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Ad;
use App\Models\Click;
use App\Models\Impression;
use App\Models\WalletTransaction;
use App\Services\Ledger\LedgerService;
use App\Services\Fraud\FraudAnalyticsService;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        private LedgerService $ledger,
        private FraudAnalyticsService $fraud
    ) {}


    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function admin(): array
    {
        return Cache::remember('dashboard:admin', 60, function () {

            $clicks = Click::count();

            $impressions = Impression::count();


            $validClicks = Click::where(
                'is_fraud',
                0
            )->count();


            $fraudClicks = Click::where(
                'is_fraud',
                1
            )->count();



            return [

                'users' => User::count(),

                'advertisers' =>
                    User::where('role','advertiser')->count(),

                'publishers' =>
                    User::where('role','publisher')->count(),


                'campaigns' => Campaign::count(),

                'ads' => Ad::count(),


                'clicks' => $clicks,

                'impressions' => $impressions,


                'ctr' => $this->ctr(
                    $clicks,
                    $impressions
                ),



                'ledger' => [

                    'valid_clicks' => $validClicks,

                    'fraud_clicks' => $fraudClicks,


                    'total_spend' =>
                        (float) WalletTransaction::query()
                        ->where(
                            'type',
                            WalletTransaction::TYPE_CAMPAIGN_CHARGE
                        )
                        ->where(
                            'reference_type',
                            'click'
                        )
                        ->sum('amount'),



                    'total_earnings' =>
                        (float) WalletTransaction::query()
                        ->where(
                            'type',
                            WalletTransaction::TYPE_EARNING
                        )
                        ->sum('amount'),

                ],



                'fraud' => [

                    'rate' =>
                        $this->fraud->fraudRate(),


                    'suspicious_clicks' =>
                        $this->fraud->totalSuspiciousClicks(),


                    'avg_score' =>
                        $this->fraud->averageFraudScore(),

                ],

            ];

        });
    }



    /*
    |--------------------------------------------------------------------------
    | ADVERTISER DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function advertiser(int $userId): array
    {

        $campaignIds = Campaign::where(
            'advertiser_id',
            $userId
        )
        ->pluck('id');



        $adsQuery = Ad::whereIn(
            'campaign_id',
            $campaignIds
        );



        $adIds = (clone $adsQuery)
            ->pluck('id');



        $clickCount = Click::whereIn(
            'ad_id',
            $adIds
        )
        ->count();



        $impressionCount = Impression::whereIn(
            'ad_id',
            $adIds
        )
        ->count();



        $spent =
            (float) WalletTransaction::query()

            ->where(
                'type',
                WalletTransaction::TYPE_CAMPAIGN_CHARGE
            )

            ->where(
                'reference_type',
                'click'
            )

            ->whereIn(
                'reference_id',
                Click::whereIn(
                    'ad_id',
                    $adIds
                )
                ->pluck('id')
            )

            ->sum('amount');



        return [

    'campaigns' =>
        $campaignIds->count(),

    'ads' =>
        $adsQuery->count(),

    'active_ads' =>
        Ad::whereIn('campaign_id', $campaignIds)
            ->where('status', 'active')
            ->count(),

    'clicks' =>
        $clickCount,

    'impressions' =>
        $impressionCount,

    'ctr' =>
        $this->ctr(
            $clickCount,
            $impressionCount
        ),

    'total_spent' =>
        abs($spent),

];
    }



    /*
    |--------------------------------------------------------------------------
    | PUBLISHER DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function publisher(int $publisherId): array
    {
        return Cache::remember(
            "dashboard:publisher:$publisherId",
            60,
            function () use ($publisherId) {

                $clicks = Click::where(
                    'publisher_id',
                    $publisherId
                );


                $impressions = Impression::where(
                    'publisher_id',
                    $publisherId
                );



                $totalClicks =
                    (clone $clicks)->count();



                $todayClicks =
                    (clone $clicks)
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->count();



                $yesterdayClicks =
                    (clone $clicks)
                    ->whereDate(
                        'created_at',
                        now()->subDay()
                    )
                    ->count();



                $earningsQuery =
                    WalletTransaction::query()

                    ->where(
                        'type',
                        WalletTransaction::TYPE_EARNING
                    )

                    ->whereHas(
                        'wallet',
                        function ($q) use ($publisherId) {

                            $q->where(
                                'owner_type',
                                User::class
                            )
                            ->where(
                                'owner_id',
                                $publisherId
                            );

                        }
                    );



                $totalEarnings =
                    (float) (clone $earningsQuery)
                    ->sum('amount');



                $todayEarnings =
                    (float) (clone $earningsQuery)
                    ->whereDate(
                        'created_at',
                        today()
                    )
                    ->sum('amount');



                $yesterdayEarnings =
                    (float) (clone $earningsQuery)
                    ->whereDate(
                        'created_at',
                        now()->subDay()
                    )
                    ->sum('amount');

                   /*
                |--------------------------------------------------------------------------
                | TOP ZONES
                |--------------------------------------------------------------------------
                */

                $topZones = Click::query()

                    ->where(
                        'clicks.publisher_id',
                        $publisherId
                    )

                    ->leftJoin(
                        'wallet_transactions',
                        function ($join) {

                            $join->on(
                                'wallet_transactions.reference_id',
                                '=',
                                'clicks.id'
                            )

                            ->where(
                                'wallet_transactions.reference_type',
                                'click'
                            )

                            ->where(
                                'wallet_transactions.type',
                                WalletTransaction::TYPE_EARNING
                            );

                        }
                    )

                    ->leftJoin(
                        'ad_zones',
                        'ad_zones.id',
                        '=',
                        'clicks.zone_id'
                    )

                    ->selectRaw('
                        clicks.zone_id,
                        ad_zones.name,
                        COUNT(clicks.id) as clicks,
                        COALESCE(
                            SUM(wallet_transactions.amount),
                            0
                        ) as earnings
                    ')

                    ->groupBy(
                        'clicks.zone_id',
                        'ad_zones.name'
                    )

                    ->orderByDesc(
                        'clicks'
                    )

                    ->limit(10)

                    ->get()

                 ->map(function ($zone) {

    return [

        'zone_id' =>
            $zone->zone_id,

        'name' =>
            $zone->name ?: ('Zone #' . $zone->zone_id),

        'clicks' =>
            (int) $zone->clicks,

        'earnings' =>
            (float) $zone->earnings,

    ];

})   
                    

                    ->toArray();



                /*
                |--------------------------------------------------------------------------
                | TOP ADS
                |--------------------------------------------------------------------------
                */

                $topAds = Click::query()

                    ->where(
                        'clicks.publisher_id',
                        $publisherId
                    )

                    ->leftJoin(
                        'wallet_transactions',
                        function ($join) {

                            $join->on(
                                'wallet_transactions.reference_id',
                                '=',
                                'clicks.id'
                            )

                            ->where(
                                'wallet_transactions.reference_type',
                                'click'
                            )

                            ->where(
                                'wallet_transactions.type',
                                WalletTransaction::TYPE_EARNING
                            );

                        }
                    )

                    ->leftJoin(
                        'ads',
                        'ads.id',
                        '=',
                        'clicks.ad_id'
                    )

                    ->selectRaw('
                        clicks.ad_id,
                        ads.title,
                        COUNT(clicks.id) as clicks,
                        COALESCE(
                            SUM(wallet_transactions.amount),
                            0
                        ) as earnings
                    ')

                    ->groupBy(
                        'clicks.ad_id',
                        'ads.title'
                    )

                    ->orderByDesc(
                        'clicks'
                    )

                    ->limit(10)

                    ->get()

                    ->map(function ($ad) {

                        return [

                            'ad_id' =>
                                $ad->ad_id,

                            'title' =>
                                $ad->title
                                ?: ('Ad #' . $ad->ad_id),

                            'clicks' =>
                                (int) $ad->clicks,

                            'earnings' =>
                                (float) $ad->earnings,

                        ];

                    })

                    ->toArray();



                $totalImpressions =
                    (clone $impressions)->count();



                return [

                    'today' => [

                        'clicks' =>
                            $todayClicks,

                        'earnings' =>
                            $todayEarnings,

                    ],


                    'yesterday' => [

                        'clicks' =>
                            $yesterdayClicks,

                        'earnings' =>
                            $yesterdayEarnings,

                    ],


                    'total' => [

                        'clicks' =>
                            $totalClicks,

                        'impressions' =>
                            $totalImpressions,

                        'earnings' =>
                            $totalEarnings,

                    ],


                    'epc' =>
                        $totalClicks > 0
                        ? round(
                            $totalEarnings / $totalClicks,
                            6
                        )
                        : 0,


                    'ctr' =>
                        $this->ctr(
                            $totalClicks,
                            $totalImpressions
                        ),


                    'top_zones' =>
                        $topZones,


                    'top_ads' =>
                        $topAds,

                ];

            }
        );
    }



    /*
    |--------------------------------------------------------------------------
    | CTR HELPER
    |--------------------------------------------------------------------------
    */

    private function ctr(
        int $clicks,
        int $impressions
    ): float {

        return $impressions > 0

            ? round(
                ($clicks / $impressions) * 100,
                2
            )

            : 0;
    }
}                 