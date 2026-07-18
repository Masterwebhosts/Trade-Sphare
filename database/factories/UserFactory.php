<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),

            // default role but still overridable
            'role' => 'advertiser',

            'password' => static::$password ??= Hash::make('password'),

            'remember_token' => Str::random(10),
        ];
    }

    /*
    |-----------------------------
    | STATES (IMPORTANT FOR ADTECH TESTING)
    |-----------------------------
    */

    public function advertiser(): static
    {
        return $this->state(fn () => [
            'role' => 'advertiser',
        ]);
    }

    public function publisher(): static
    {
        return $this->state(fn () => [
            'role' => 'publisher',
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role' => 'admin',
        ]);
    }
}