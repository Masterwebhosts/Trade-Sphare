<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdZone;
use App\Services\AdSelectionService;
use App\Services\AdRankingService;
use Illuminate\Http\Request;

class ZoneAdController extends Controller
{
    public function serve(
        $zoneId,
        Request $request,
        AdSelectionService $selector,
        AdRankingService $ranker
    ) {
        $zone = AdZone::find($zoneId);

        if (!$zone || !$zone->is_active) {
            return response()->json(['message' => 'Zone not found'], 404);
        }

        $ads = $selector->select(
            $zone,
            $request->get('governorate_id')
        );

        if ($ads->isEmpty()) {
            return response()->json(['message' => 'No ads available'], 404);
        }

        $ad = $ranker->getBestAd($ads);

        if (!$ad) {
            return response()->json(['message' => 'No ads available'], 404);
        }

        return response()->json([
            'id' => $ad->id,
            'title' => $ad->title,
            'image_url' => !empty($ad->image_url)
    ? $ad->image_url
    : asset('images/default-ad.png'),
            'target_url' => $ad->target_url,
            'zone_id' => $zone->id,
            'campaign_id' => $ad->campaign_id,
        ]);
    }
}
