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
            ->where('id', $zoneId)
            ->where('status', 'active')
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
        | Delegate selection
        |--------------------------------------------------------------------------
        */

        return $this->selectionService->serve(
            zoneId: $zone->id,
            publisherId: $zone->publisher_id
        );

    }
}