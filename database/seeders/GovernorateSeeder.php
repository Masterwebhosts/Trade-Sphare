<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Damascus', 'slug' => 'damascus', 'country' => 'Syria'],
            ['name' => 'Aleppo', 'slug' => 'aleppo', 'country' => 'Syria'],
            ['name' => 'Homs', 'slug' => 'homs', 'country' => 'Syria'],
            ['name' => 'Latakia', 'slug' => 'latakia', 'country' => 'Syria'],
            ['name' => 'Hama', 'slug' => 'hama', 'country' => 'Syria'],
            ['name' => 'Daraa', 'slug' => 'daraa', 'country' => 'Syria'],
            ['name' => 'Idlib', 'slug' => 'idlib', 'country' => 'Syria'],
            ['name' => 'Deir ez-Zor', 'slug' => 'deir-ez-zor', 'country' => 'Syria'],
            ['name' => 'Raqqa', 'slug' => 'raqqa', 'country' => 'Syria'],
            ['name' => 'Hasakah', 'slug' => 'hasakah', 'country' => 'Syria'],
            ['name' => 'Quneitra', 'slug' => 'quneitra', 'country' => 'Syria'],
            ['name' => 'Tartus', 'slug' => 'tartus', 'country' => 'Syria'],
        ];

        foreach ($items as $item) {
            DB::table('governorates')->updateOrInsert(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'country' => $item['country'],

                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}