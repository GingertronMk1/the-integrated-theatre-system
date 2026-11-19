<?php

namespace Database\Factories;

use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingItem>
 */
class TrainingItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(), 'training_category_id' => TrainingCategory::factory(), 'dangerous' => false,
        ];
    }
}
