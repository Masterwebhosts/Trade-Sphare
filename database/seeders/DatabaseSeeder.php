<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            // Users
            AdminUserSeeder::class,

            // Locations
            GovernorateSeeder::class,

            // Wallets
            WalletSeeder::class,

            // Advertising contracts
            CampaignSeeder::class,

            // Advertising materials
            AdSeeder::class,

            // Delivery zones
            AdZoneSeeder::class,

            // System defaults
            SystemBootstrapSeeder::class,
        ]);
    }
}