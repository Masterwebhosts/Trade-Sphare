<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AdZone;

class AdService
{
    public function __construct(
        protected AdSelectionService $selectionService
    ) {
    }



    /**
     * Get advertisement for zone
     */
    public function getAdForZone(int $zoneId): ?Ad
    {


        /*
        |--------------------------------------------------------------------------
        | Load active zone
        |--------------------------------------------------------------------------
        */

        $zone = AdZone::query()
    ->whereKey($zoneId)
    ->where(
        'status',
        AdZone::STATUS_ACTIVE
    )
    ->first();



        if (! $zone) {

            return null;

        }



        /*
        |--------------------------------------------------------------------------
        | Validate serving ability
        |--------------------------------------------------------------------------
        */

        if (! $zone->isServeable()) {

            return null;

        }



        /*
        |--------------------------------------------------------------------------
        | Select advertisement
        |--------------------------------------------------------------------------
        */

        $ad = $this->selectionService->serve(
            zoneId: $zone->id,
            publisherId: $zone->publisher_id
        );



        if (! $ad) {

            return null;

        }



        /*
        |--------------------------------------------------------------------------
        | Final advertisement validation
        |--------------------------------------------------------------------------
        */

        if (! $ad->canBeServed()) {

            return null;

        }



        return $ad;

    }
}