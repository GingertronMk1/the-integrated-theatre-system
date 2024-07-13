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
        try {
            $categoryId = TrainingCategory::all()->random()->first()?->id;
        } catch (\Throwable) {
            $categoryId = TrainingCategory::factory()->create()->id;
        }

        return [
            'name' => fake()->words(asText: true),
            'description' => fake()->paragraphs(asText: true),
            'dangerous' => fake()->boolean(),
            'training_category_id' => $categoryId,
        ];
    }
}
