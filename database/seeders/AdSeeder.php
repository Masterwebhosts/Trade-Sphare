<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\Campaign;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = Campaign::all();


        foreach ($campaigns as $campaign) {


            for ($i = 1; $i <= 3; $i++) {


                Ad::updateOrCreate(

                    [
                        'campaign_id' => $campaign->id,

                        'title' => "Demo Ad {$i}",

                    ],


                    [

                        'description' =>
                            "Test Ad Description {$i}",


                        'content_type' =>
                            'banner',


                        'media_url' =>
                            "https://example.com/image{$i}.jpg",


                        'target_url' =>
                            "https://example.com",


                        'status' =>
                            Ad::STATUS_ACTIVE,

                    ]

                );

            }

        }
    }
}