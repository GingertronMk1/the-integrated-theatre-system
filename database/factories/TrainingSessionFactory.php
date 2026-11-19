<?php

namespace Database\Factories;

use App\Models\TrainingItem;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingSession>
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
        return [
            'training_item_id' => TrainingItem::factory(), 'occurred_at' => now(),
        ];
    }
}
