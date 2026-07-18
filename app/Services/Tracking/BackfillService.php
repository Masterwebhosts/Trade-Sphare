<?php

namespace App\Services\Tracking;

use App\Models\Click;
use App\Models\Impression;
use Illuminate\Support\Facades\DB;

class BackfillService
{
    /**
     * FIX OLD CLICKS WHERE publisher_id IS NULL
     */
    public function fixClicks(): int
    {
        $updated = 0;

        Click::whereNull('publisher_id')
            ->chunkById(500, function ($clicks) use (&$updated) {

                foreach ($clicks as $click) {

                    $zone = $click->adZone;

                    if (!$zone || !$zone->publisher_id) {
                        continue;
                    }

                    $click->publisher_id = $zone->publisher_id;
                    $click->save();

                    $updated++;
                }
            });

        return $updated;
    }

    /**
     * FIX OLD IMPRESSIONS WHERE publisher_id IS NULL
     */
    public function fixImpressions(): int
    {
        $updated = 0;

        Impression::whereNull('publisher_id')
            ->chunkById(500, function ($impressions) use (&$updated) {

                foreach ($impressions as $impression) {

                    $zone = $impression->adZone;

                    if (!$zone || !$zone->publisher_id) {
                        continue;
                    }

                    $impression->publisher_id = $zone->publisher_id;
                    $impression->save();

                    $updated++;
                }
            });

        return $updated;
    }

    /**
     * RUN FULL BACKFILL PROCESS
     */
    public function run(): array
    {
        DB::beginTransaction();

        try {
            $clicks = $this->fixClicks();
            $impressions = $this->fixImpressions();

            DB::commit();

            return [
                'status' => 'success',
                'clicks_fixed' => $clicks,
                'impressions_fixed' => $impressions,
            ];

        } catch (\Throwable $e) {
            DB::rollBack();

            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}