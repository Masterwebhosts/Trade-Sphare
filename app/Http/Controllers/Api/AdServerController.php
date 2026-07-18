<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdZone;
use App\Services\AdSelectionService;
use App\Services\Tracking\ClickService;
use App\Services\Tracking\ImpressionService;
use Illuminate\Http\Request;

class AdServerController extends Controller
{
    public function __construct(
        protected AdSelectionService $selection,
        protected ClickService $clickService,
        protected ImpressionService $impressionService
    ) {
    }


    /**
     * Get advertisement for zone
     */
    public function getAd(Request $request)
    {
        $zoneId = (int) $request->query('zone');

        $zone = AdZone::where('id', $zoneId)
            ->where('status', 'active')
            ->first();


        if (! $zone) {
            return response()->json([
                'status' => 'invalid_zone',
                'ad' => null,
            ], 404);
        }


        $ad = $this->selection->serve(
            $zone->id,
            $zone->publisher_id,
            $request->ip()
        );


        if (! $ad) {
            return response()->json([
                'status' => 'no_ads_available',
                'ad' => null,
            ]);
        }


        $this->impressionService->record(
            $ad,
            $request,
            [
                'publisher_id' => $zone->publisher_id,
                'zone_id' => $zone->id,
                'channel' => 'web',
            ]
        );


        return response()->json([
            'status' => 'ok',

            'id' => $ad->id,

            'title' => $ad->title,

            'description' => $ad->description,

            'content_type' => $ad->content_type,

            'media_url' => $ad->media_url,

            'target_url' => $ad->target_url,

            'go_url' =>
                url("/go/{$ad->id}?zone={$zone->id}"),
        ]);
    }



    /**
     * Click redirect
     */
    public function click(Request $request, $id)
    {
        $ad = Ad::findOrFail($id);


        $this->clickService->record(
            $ad,
            $request,
            [
                'publisher_id' => $request->query('pub'),
                'zone_id' => $request->query('zone'),
                'channel' => 'web',
            ]
        );


        return redirect()
            ->away($ad->target_url);
    }



    /**
     * Impression endpoint
     */
    public function impression(Request $request)
    {
        $ad = Ad::find($request->input('ad_id'));


        if (! $ad) {
            return response()->json([
                'status' => 'invalid_ad',
            ],400);
        }


        $this->impressionService->record(
            $ad,
            $request,
            [
                'publisher_id' => $request->publisher_id,
                'zone_id' => $request->zone_id,
                'channel' => 'api',
            ]
        );


        return response()->json([
            'status'=>'ok'
        ]);
    }



    /**
     * Serve by zone token
     */
    public function serve($token)
    {
        $zone = AdZone::where('token',$token)
            ->where('status','active')
            ->first();


        if (! $zone) {

            return response()->json([
                'status'=>'zone_not_found'
            ],404);

        }


        $ad = $this->selection->serve(
            $zone->id,
            $zone->publisher_id,
            request()->ip()
        );


        if (! $ad) {

            return response()->json([
                'status'=>'no_ads_available'
            ]);

        }


        return response()->json([

            'status'=>'ok',

            'id'=>$ad->id,

            'title'=>$ad->title,

            'content_type'=>$ad->content_type,

            'media_url'=>$ad->media_url,

            'target_url'=>$ad->target_url,

        ]);
    }



    /**
     * Click tracking API
     */
    public function clickTrack(Request $request)
    {
        $ad = Ad::find($request->input('ad_id'));


        if (! $ad) {

            return response()->json([
                'status'=>'invalid_ad'
            ],400);

        }


        $this->clickService->record(
            $ad,
            $request,
            [
                'publisher_id'=>$request->publisher_id,
                'zone_id'=>$request->zone_id,
                'channel'=>'api',
            ]
        );


        return response()->json([
            'status'=>'ok'
        ]);
    }
}