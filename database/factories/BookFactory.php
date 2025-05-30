<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'external_id' => fake()->randomNumber(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'author' => fake()->name(),
            'status' => 'available',
            'published_at' => now(),
            'user_id' => User::factory()
        ];
    }
}
