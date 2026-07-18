<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdZone;
use App\Models\User;
use Illuminate\Support\Str;

class AdZoneSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = User::where(
            'role',
            'publisher'
        )->get();



        foreach ($publishers as $publisher) {


            AdZone::updateOrCreate(

                [
                    'publisher_id' => $publisher->id,

                    'name' => 'Main Banner Zone',
                ],


                [
                    'zone_type' => 'banner',

                    'token' => Str::random(32),

                    'status' => AdZone::STATUS_ACTIVE,

                    'governorate_id' => null,
                ]

            );



            AdZone::updateOrCreate(

                [
                    'publisher_id' => $publisher->id,

                    'name' => 'Native Zone',
                ],


                [
                    'zone_type' => 'native',

                    'token' => Str::random(32),

                    'status' => AdZone::STATUS_ACTIVE,

                    'governorate_id' => null,
                ]

            );

        }
    }
}