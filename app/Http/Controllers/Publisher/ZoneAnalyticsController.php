<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\AdZone;
use App\Models\Click;
use App\Models\Impression;

class ZoneAnalyticsController extends Controller
{
    public function index($zoneId)
    {
        $publisherId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | ZONE VALIDATION
        |--------------------------------------------------------------------------
        */

        $zone = AdZone::where('id', $zoneId)
            ->where('publisher_id', $publisherId)
            ->firstOrFail();



        /*
        |--------------------------------------------------------------------------
        | CLICKS
        |--------------------------------------------------------------------------
        */

        $clicksQuery = Click::where('zone_id', $zoneId)
            ->where('publisher_id', $publisherId);



        $clicks = $clicksQuery->count();



        $validClicks = (clone $clicksQuery)
            ->where('is_fraud', false)
            ->count();



        $suspiciousClicks = (clone $clicksQuery)
            ->where('is_fraud', true)
            ->count();



        /*
        |--------------------------------------------------------------------------
        | REJECTED CLICKS
        |--------------------------------------------------------------------------
        |
        | لا يوجد status في جدول clicks حالياً
        |
        */

        $rejectedClicks = 0;




        /*
        |--------------------------------------------------------------------------
        | IMPRESSIONS
        |--------------------------------------------------------------------------
        */

        $impressions = Impression::where('zone_id', $zoneId)
            ->count();



        /*
        |--------------------------------------------------------------------------
        | CTR
        |--------------------------------------------------------------------------
        */

        $ctr = $impressions > 0
            ? round(($clicks / $impressions) * 100, 2)
            : 0;




        /*
        |--------------------------------------------------------------------------
        | EARNINGS
        |--------------------------------------------------------------------------
        |
        | الأرباح = النقرات الصحيحة × CPC الخاص بالحملة
        |
        */

        $earnings = Click::where('zone_id', $zoneId)
            ->where('publisher_id', $publisherId)
            ->where('is_fraud', false)
            ->with([
                'ad.campaign'
            ])
            ->get()
            ->sum(function ($click) {

                return $click->ad?->campaign?->cpc ?? 0;

            });




        /*
        |--------------------------------------------------------------------------
        | AVG CPC
        |--------------------------------------------------------------------------
        */

        $avgCpc = $validClicks > 0
            ? $earnings / $validClicks
            : 0;




        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return view(
    'publisher.zones.analytics',
    [
                'zone'             => $zone,

                'impressions'      => $impressions,

                'clicks'           => $clicks,

                'validClicks'      => $validClicks,

                'suspiciousClicks' => $suspiciousClicks,

                'rejectedClicks'   => $rejectedClicks,

                'earnings'         => $earnings,

                'avgCpc'            => $avgCpc,

                'ctr'              => $ctr,
            ]
        );
    }
}