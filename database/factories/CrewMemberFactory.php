<?php

namespace Database\Factories;

use App\Models\CrewRole;
use App\Models\Person;
use App\Models\Show;
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
            'crew_role_id' => CrewRole::query()->count() < 5 ? CrewRole::factory() : CrewRole::query()->inRandomOrder()->first(),
            'show_id' => Show::query()->count() < 5 ? Show::factory() : Show::query()->inRandomOrder()->first(),
            'person_id' => Person::query()->count() < 5 ? Person::factory() : Person::query()->inRandomOrder()->first(),
            'notes' => $this->faker->boolean() ? $this->faker->sentence() : null,
        ];
    }
}
