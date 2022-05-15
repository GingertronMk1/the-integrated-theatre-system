<?php

namespace Database\Factories\Show;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Show\Show>
 */
class ShowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(5, true),
            'description' => $this->faker->text(),
            'default_venue_id' => \App\Models\Show\Venue::all()->random()->id,
            'season_id' => \App\Models\Show\Season::all()->random()->id,
        ];
    }
}
