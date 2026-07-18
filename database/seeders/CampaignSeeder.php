<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\User;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        $advertisers = User::where(
            'role',
            'advertiser'
        )->get();


        foreach ($advertisers as $index => $user) {


            Campaign::updateOrCreate(

                [

                    'advertiser_id' => $user->id,

                    'title' => "Campaign {$index}",

                ],


                [

                    'description' =>
                        "Demo campaign {$index}",


                    'status' =>
                        Campaign::STATUS_APPROVED,


                    'budget_total' =>
                        1000,


                    'budget_spent' =>
                        0,


                    'budget_remaining' =>
                        1000,


                    'cpc' =>
                        0.50,


                    'start_date' =>
                        now()->startOfDay(),


                    'end_date' =>
                        now()->addDays(30)->endOfDay(),


                ]

            );

        }
    }
}