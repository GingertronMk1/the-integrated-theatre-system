<?php

namespace Database\Factories;

use App\Models\TrainingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingItem>
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
            'name' => fake()->words(asText: true),
            'description' => fake()->paragraphs(asText: true),
            'dangerous' => fake()->boolean(),
            'training_category_id' => TrainingCategory::all()->pluck('id')->random(),
        ];
    }
}
