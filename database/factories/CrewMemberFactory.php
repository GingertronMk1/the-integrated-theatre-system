<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CrewMember>
 */
class CrewMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'show_id' => (new ShowFactory)->create(),
            'crew_role_id' => (new CrewRoleFactory)->create(),
            'person_id' => (new PersonFactory)->create(),
            'notes' => fake()->paragraph(),
        ];
    }
}
