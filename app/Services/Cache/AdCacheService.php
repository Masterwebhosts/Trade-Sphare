<?php

namespace App\Services\Cache;

use App\Models\Ad;
use App\Models\Campaign;
use Illuminate\Support\Facades\Cache;

class AdCacheService
{
    public const CACHE_KEY = 'ads:pool:v3';

    public const TTL = 60;



    /**
     * Build active ads pool
     */
    public function warmPool(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            self::TTL,
            function () {


                return Ad::query()

                    ->with('campaign')

                    ->where(
                        'status',
                        Ad::STATUS_ACTIVE
                    )

                    ->whereHas(
                        'campaign',
                        function ($query) {

                            $query->where(
                                'status',
                                Campaign::STATUS_APPROVED
                            );

                        }
                    )

                    ->orderByDesc('id')

                    ->limit(200)

                    ->get()

                    ->filter(function (Ad $ad) {


                        return $ad->campaign
                            && $ad->campaign->canServeAds();


                    })

                    ->map(function (Ad $ad) {


                        return [

                            'id' => $ad->id,


                            'campaign_id' =>
                                $ad->campaign_id,


                            'title' =>
                                $ad->title,


                            'description' =>
                                $ad->description,


                            'content_type' =>
                                $ad->content_type,


                            'media_url' =>
                                $ad->media_url,


                            'target_url' =>
                                $ad->target_url,


                            /*
                            |--------------------------------------------------------------------------
                            | Campaign data
                            |--------------------------------------------------------------------------
                            */

                            'campaign_status' =>
                                $ad->campaign->status,


                            'governorate_id' =>
                                $ad->campaign->governorate_id,


                            /*
                            |--------------------------------------------------------------------------
                            | Selection weight
                            |--------------------------------------------------------------------------
                            */

                            'score' =>
                                (float) $ad->campaign->cpc,


                        ];


                    })

                    ->values()

                    ->toArray();

            }
        );
    }




    /**
     * Get cached pool
     */
    public function getPool(): array
    {
        return Cache::get(
            self::CACHE_KEY,
            []
        );
    }




    /**
     * Force rebuild
     */
    public function refresh(): void
    {
        $this->invalidate();

        $this->warmPool();
    }




    /**
     * Remove cache
     */
    public function invalidate(): void
    {
        Cache::forget(
            self::CACHE_KEY
        );
    }
}