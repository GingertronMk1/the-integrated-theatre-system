<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CastMember>
 */
class CastMemberFactory extends Factory
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
            'role_name' => fake()->words(3, true),
            'person_id' => (new PersonFactory)->create(),
        ];
    }
}
