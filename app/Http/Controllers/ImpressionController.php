<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Services\Tracking\ImpressionService;

class ImpressionController extends Controller
{

    public function __construct(
        protected ImpressionService $impressionService
    ){}



    public function serve(Request $request)
    {

        $ad = Ad::query()
            ->where('status', Ad::STATUS_ACTIVE)
            ->first();


        if(!$ad){

            return response()->json([
                'success'=>false,
                'message'=>'No ads available'
            ],404);

        }



        $this->impressionService->record(
            $ad,
            $request,
            [
                'zone_id'=>$request->zone_id,
                'publisher_id'=>$request->publisher_id,
            ]
        );



        return response()->json([

            'success'=>true,

            'data'=>[
                'ad_id'=>$ad->id,
                'title'=>$ad->title,
                'url'=>$ad->target_url,
                'image'=>$ad->media_url,
            ]

        ]);

    }

}