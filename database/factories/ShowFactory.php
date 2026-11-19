<?php

namespace Database\Factories;

use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Show>
 */
class ShowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3), 'description' => fake()->paragraph(), 'year' => '2024', 'playwright_id' => Playwright::factory(), 'season_id' => Season::factory(),
        ];
    }
}
