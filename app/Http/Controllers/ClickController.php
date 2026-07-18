<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdZone;
use Illuminate\Http\Request;
use App\Services\Tracking\ClickService;

class ClickController extends Controller
{
    public function __construct(
        protected ClickService $clickService
    ) {}

    public function track(Request $request, $adId, $zoneId)
    {
        $ad = Ad::where('id', $adId)
            ->where('state', 'active')
            ->first();

        if (!$ad) {
            return response()->json(['error' => 'ad not found'], 404);
        }

        $zone = AdZone::where('id', $zoneId)
            ->where('is_active', 1)
            ->first();

        if (!$zone) {
            return response()->json(['error' => 'zone not found'], 404);
        }

        $this->clickService->record(
            $ad,
            $request,
            [
                'ad_zone_id' => $zone->id
            ]
        );

        return redirect()->away($ad->target_url);
    }
}