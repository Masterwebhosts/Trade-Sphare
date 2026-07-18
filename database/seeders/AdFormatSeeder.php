<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdFormat;

class AdFormatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Banner 300x250',
                'slug' => 'banner-300x250',
                'code' => 'B300x250',
                'size' => '300x250',
                'description' => 'Medium rectangle banner',
                'status' => 'active',
                'supports_video' => 0,
                'supports_image' => 1,
                'max_assets' => 1,
            ],
            [
                'name' => 'Banner 728x90',
                'slug' => 'banner-728x90',
                'code' => 'B728x90',
                'size' => '728x90',
                'description' => 'Leaderboard banner',
                'status' => 'active',
                'supports_video' => 0,
                'supports_image' => 1,
                'max_assets' => 1,
            ],
            [
                'name' => 'Skyscraper 160x600',
                'slug' => 'skyscraper-160x600',
                'code' => 'S160x600',
                'size' => '160x600',
                'description' => 'Vertical banner',
                'status' => 'active',
                'supports_video' => 0,
                'supports_image' => 1,
                'max_assets' => 1,
            ],
            [
                'name' => 'Native Feed',
                'slug' => 'native-feed',
                'code' => 'NATIVE',
                'size' => null,
                'description' => 'In-feed native ads',
                'status' => 'active',
                'supports_video' => 1,
                'supports_image' => 1,
                'max_assets' => 5,
            ],
            [
                'name' => 'Video 16:9',
                'slug' => 'video-16-9',
                'code' => 'V16X9',
                'size' => '16:9',
                'description' => 'Video ads',
                'status' => 'active',
                'supports_video' => 1,
                'supports_image' => 0,
                'max_assets' => 1,
            ],
        ];

        foreach ($data as $item) {
            AdFormat::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
