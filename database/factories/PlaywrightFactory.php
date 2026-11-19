<?php

namespace Database\Factories;

use App\Models\Playwright;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Playwright>
 */
class PlaywrightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), 'bio' => fake()->paragraph(), 'external_links' => [],
        ];
    }
}
