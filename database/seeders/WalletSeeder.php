<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run(): void
{
    $users = User::all();

    foreach ($users as $user) {

        Wallet::firstOrCreate(
            [
                'owner_id'   => $user->id,
                'owner_type' => \App\Models\User::class,
            ],
            [
                'currency' => 'USD',
                'status'   => 'active',
            ]
        );
    }
}
}