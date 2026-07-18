<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('users')
            ->where('email', 'admin@shamads.com')
            ->exists();

        if (! $exists) {
            DB::table('users')->insert([
                'name' => 'System Admin',
                'email' => 'admin@shamads.com',
                'password_hash' => Hash::make('12345678'),
                'role' => 'admin',

                // ✅ FIX HERE
                'status' => 'active',

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}