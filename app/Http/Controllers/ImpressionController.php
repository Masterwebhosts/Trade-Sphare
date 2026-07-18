<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Impression;
use App\Services\AdRankingService;
use App\Services\CampaignBillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImpressionController extends Controller
{
    public function serve(Request $request)
    {
        $ad = app(AdRankingService::class)->getBestAd();

        if (!$ad || !$ad->campaign) {
            return response()->json([
                'success' => false,
                'message' => 'No ads available'
            ], 404);
        }

        $campaign = $ad->campaign;

        $reference = 'imp_' . uniqid();

        /*
        |---------------------------------
        | RESERVE BUDGET
        |---------------------------------
        */
        app(CampaignBillingService::class)->reserve(
            $campaign,
            $campaign->bid_value ?? 0,
            $reference
        );

        /*
        |---------------------------------
        | LOG IMPRESSION EVENT
        |---------------------------------
        */
        DB::table('ad_events')->insert([
            'ad_id'      => $ad->id,
            'zone_id'    => $request->zone_id,
            'event_type' => 'impression',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        /*
        |---------------------------------
        | STORE IMPRESSION RECORD
        |---------------------------------
        */
        Impression::create([
            'ad_id'        => $ad->id,
            'campaign_id'  => $campaign->id,
            'ad_zone_id'   => $request->zone_id,
            'ip'           => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'fingerprint'  => md5(
                $request->ip() .
                $request->userAgent()
            ),
        ]);

        return response()->json([
            'success' => true,

            'data' => [
                'ad_id' => $ad->id,
                'title' => $ad->title,
                'url'   => $ad->target_url,
                'image' => $ad->image_url ?? null,
                'type'  => $ad->type ?? null,
            ],

            'campaign_id' => $campaign->id,
            'reference'   => $reference,
        ]);
    }
}