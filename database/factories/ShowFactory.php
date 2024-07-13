<?php

namespace Database\Factories;

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
        try {
            $seasonId = Season::all()->random()->first()?->id;
        } catch (\Throwable) {
            $seasonId = Season::factory()->create()->id;
        }
        try {
            $venueId = Venue::all()->random()->first()?->id;
        } catch (\Throwable) {
            $venueId = Venue::factory()->create()->id;
        }

        return [
            'title' => fake()->words(3, true),
            'description' => fake()->paragraphs(3, true),
            'year' => fake()->year(),
            'season_id' => $seasonId,
            'venue_id' => $venueId,
        ];
    }
}
