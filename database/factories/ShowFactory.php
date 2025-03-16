<?php

namespace Database\Factories;

use App\Models\Playwright;
use App\Models\Season;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Show>
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
            'title' => fake()->words(3, true),
            'blurb' => fake()->paragraphs(3, true),
            'year' => fake()->numberBetween(1960, now()->year),
            'playwright_id' => Playwright::query()->inRandomOrder()->first(),
            'season_id' => Season::query()->inRandomOrder()->first(),
            'venue_id' => Venue::query()->inRandomOrder()->first(),
        ];
    }
}
