<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingSession>
 */
class TrainingSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        try {
            $personId = Person::all()->random()->first()->id;
        } catch (\Throwable) {
        $personId = Person::factory()->create()->id;
        }

        return [
            'trainer_id' => $personId,
            'happened_at' => fake()->dateTime(),
        ];
    }
}
