<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\AdZone;
use App\Services\Tracking\ClickService;
use App\Services\Tracking\ImpressionService;


class TrackingController extends Controller
{


    public function click(
        Request $request,
        ClickService $clickService
    ) {

        $data = $request->validate([

            'ad_id' => [
                'required',
                'exists:ads,id'
            ],

            'zone_token' => [
                'required',
                'string'
            ],

        ]);


        $ad = Ad::findOrFail(
            $data['ad_id']
        );


        $zone = AdZone::where(
            'token',
            $data['zone_token']
        )
        ->active()
        ->first();


        if (!$zone) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid zone'
            ], 404);

        }



        $click = $clickService->record(

            $ad,

            $request,

            [

                'zone' => $zone,

                'channel' => 'api',

            ]

        );



        return response()->json([

            'success' => true,

            'data' => [

                'click_id' =>
                    $click?->id,

            ]

        ]);

    }





    public function impression(
        Request $request,
        ImpressionService $impressionService
    ) {


        $data = $request->validate([

            'ad_id' => [
                'required',
                'exists:ads,id'
            ],


            'zone_token' => [
                'required',
                'string'
            ],

        ]);



        $ad = Ad::findOrFail(
            $data['ad_id']
        );



        $zone = AdZone::where(
            'token',
            $data['zone_token']
        )
        ->active()
        ->first();



        if (!$zone) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid zone'
            ],404);

        }



        $impression = $impressionService->record(

            $ad,

            $request,

            [

                'zone' => $zone,

                'channel'=>'api',

            ]

        );



        return response()->json([

            'success'=>true,

            'data'=>[

                'impression_id'=>
                    $impression?->id,

            ]

        ]);

    }


}