<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminUser>
 */
class AdminUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => fake()->name,
            'email' => fake()->unique()->email,
            'password' => '12345j',
            'is_banned' => false,
            'remember_token' => Str::random(10),
        ];
    }
}
