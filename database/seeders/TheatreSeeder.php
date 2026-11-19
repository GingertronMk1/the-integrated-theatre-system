<?php

namespace Database\Seeders;

use App\Models\Performance;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Role;
use App\Models\Season;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use App\Models\Venue;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    public function run(): void
    {
        $people = Person::factory()->count(1000)->create();
        $roles = Role::factory()->count(10)->create();
        $venues = Venue::factory()->count(5)->create();
        $playwrights = Playwright::factory()->count(5)->create();
        $seasons = Season::factory()->count(5)->create();

        for ($showIndex = 0; $showIndex < 100; $showIndex++) {
            $firstPerformance = CarbonImmutable::instance(fake()->dateTimeBetween('-2 years', '+1 year'))->setTime(19, 30);
            $show = Show::factory()
                ->for($playwrights->random())
                ->for($seasons->random())
                ->create(['year' => $firstPerformance->format('Y')]);

            foreach ($people->random(fake()->numberBetween(5, 20)) as $person) {
                ShowCast::factory()->for($show)->for($person)->create();
            }

            foreach ($people->random(fake()->numberBetween(10, 50)) as $person) {
                ShowCrew::factory()->for($show)->for($person)->for($roles->random())->create();
            }

            $venue = $venues->random();
            $performanceCount = fake()->numberBetween(3, 5);

            for ($day = 0; $day < $performanceCount; $day++) {
                Performance::factory()->for($show)->for($venue)->create([
                    'show_start' => $firstPerformance->addDays($day)->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
