<?php

namespace Database\Factories;

use App\Models\Person;
use App\Models\Show;
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
            'role' => $this->faker->word(),
            'show_id' => Show::query()->count() < 5 ? Show::factory() : Show::query()->inRandomOrder()->first(),
            'person_id' => Person::query()->count() < 5 ? Person::factory() : Person::query()->inRandomOrder()->first(),
        ];
    }
}
