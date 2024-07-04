<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        $endYear = Carbon::instance(fake()->dateTime());
        $startYear = (clone $endYear)->subYears(fake()->numberBetween(1, 3));

        return [
            'name' => fake()->name(),
            'start_year' => $startYear->year,
            'end_year' => $endYear->year,
        ];
    }
}
