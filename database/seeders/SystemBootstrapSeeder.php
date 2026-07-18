<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class SystemBootstrapSeeder extends Seeder
{
    public function run(): void
    {
        // ضمان وجود wallet لكل مستخدم
        $users = User::all();

        foreach ($users as $user) {
            Wallet::firstOrCreate([
                'owner_type' => User::class,
                'owner_id' => $user->id,
            ]);
        }
    }
}
