<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\TrainingSession;
use App\Models\TrainingSessionPerson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingSessionPerson>
 */
class TrainingSessionPersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'training_session_id' => TrainingSession::factory(), 'person_id' => Person::factory(), 'type' => 'trainee',
        ];
    }
}
