<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Show;
use App\Models\ShowCast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShowCast>
 */
class ShowCastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'show_id' => Show::factory(), 'person_id' => Person::factory(), 'role_name' => fake()->name(),
        ];
    }
}
