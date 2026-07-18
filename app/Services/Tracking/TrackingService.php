<?php

namespace App\Services\Tracking;

use App\Models\Click;
use App\Models\Impression;
use Illuminate\Http\Request;

class TrackingService
{
    public function __construct(
        protected ImpressionService $impressionService,
        protected ClickService $clickService
    ) {}



    /**
     * Resolve tracking context
     */
    public function resolveContext($ad, $zone): array
    {
        if (!$ad) {
            throw new \RuntimeException(
                "Ad not found in tracking context"
            );
        }


        if (!$zone) {
            throw new \RuntimeException(
                "Zone not found in tracking context"
            );
        }


        if (!$zone->publisher_id) {
            throw new \RuntimeException(
                "Zone missing publisher_id"
            );
        }


        return [

            'ad_id' =>
                $ad->id,

            'campaign_id' =>
                $ad->campaign_id,

            'zone_id' =>
                $zone->id,

            'publisher_id' =>
                $zone->publisher_id,

        ];
    }





    /**
     * Impression tracking
     */
    public function impression(
        $ad,
        $zone,
        Request $request
    ): ?Impression {

        return $this->impressionService->record(

            $ad,

            $request,

            [
                'zone' => $zone,
                'channel' => 'tracking',
            ]

        );
    }






    /**
     * Click tracking
     */
    public function click(
        $ad,
        $zone,
        Request $request
    ): ?Click {

        return $this->clickService->record(

            $ad,

            $request,

            [
                'zone' => $zone,
                'channel' => 'tracking',
            ]

        );
    }
}