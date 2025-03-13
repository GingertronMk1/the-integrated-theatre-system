<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startYear = (int) fake()->year();
        $endYear = $startYear + fake()->randomDigit();
        return [
            'name' => fake()->name(),
            'user_id' => fake()->boolean() ? User::factory()->create() : null,
            'start_year' => $startYear,
            'end_year' => $endYear,
        ];
    }
}
