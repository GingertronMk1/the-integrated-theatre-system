<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Role;
use App\Models\Show;
use App\Models\ShowCrew;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShowCrew>
 */
class ShowCrewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'show_id' => Show::factory(), 'person_id' => Person::factory(), 'role_id' => Role::factory(),
        ];
    }
}
