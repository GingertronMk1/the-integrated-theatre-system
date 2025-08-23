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
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'venue_id' => Venue::query()->count() < 5 ? Venue::factory() : Venue::query()->inRandomOrder()->first(),
            'season_id' => Season::query()->count() < 5 ? Season::factory() : Season::query()->inRandomOrder()->first(),
            'playwright_id' => Playwright::query()->count() < 5 ? Playwright::factory() : Playwright::query()->inRandomOrder()->first(),
        ];
    }
}
