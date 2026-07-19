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
    ) {
    }



    public function track(
        Request $request,
        $adId,
        $zoneId
    ) {

        $ad = Ad::query()
            ->where('id', $adId)
            ->active()
            ->first();



        if (! $ad) {

            return response()->json([
                'error' => 'ad not found'
            ], 404);

        }



        if (! $ad->canBeServed()) {

            return response()->json([
                'error' => 'ad cannot be served'
            ], 404);

        }



        $zone = AdZone::query()
            ->where('id', $zoneId)
            ->active()
            ->first();



        if (! $zone) {

            return response()->json([
                'error' => 'zone not found'
            ], 404);

        }



        if (! $zone->isServeable()) {

            return response()->json([
                'error' => 'zone not serveable'
            ], 404);

        }



        $this->clickService->record(
            $ad,
            $request,
            [
                'zone' => $zone
            ]
        );



        return redirect()->away(
            $ad->target_url
        );
    }
}