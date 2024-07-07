<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Performance>
 */
class PerformanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $showStart = new CarbonImmutable(fake()->dateTimeThisCentury());
        $doors = $showStart->subMinutes(30);

        return [
            'venue' => fake()->address(),
            'show_start' => $showStart,
            'doors' => $doors,
            'capacity' => fake()->numberBetween(5, 1000),
        ];
    }
}
