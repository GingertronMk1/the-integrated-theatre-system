<?php

namespace Database\Seeders;

use App\Models\Performance;
use App\Models\Person;
use App\Models\Season;
use App\Models\Show;
use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use App\Models\TrainingSession;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Seeding admin user');
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->person()->create([
            'name' => 'Test Person',
            'start_year' => 2007,
            'end_year' => 2017,
        ]);

        $this->command->info('Seeding base classes - those which do not belong to any others');
        TrainingCategory::factory(10)
            ->has(TrainingItem::factory(10))
            ->create()
        ;

        Season::factory(10)->create();

        Venue::factory(10)->create();

        $personProgressBar = new ProgressBar($this->command->getOutput());

        $personJson = Storage::json('person-fixtures.json');

        $this->command->info('Seeding people - every other person gets a user attached to them');
        foreach ($personProgressBar->iterate($personJson) as $personIndex => $person) {
            $personName = $person['name'];
            $person = Person::factory()->create([
                'name' => $personName,
            ]);

            if ($personIndex % 2) {
                $personEmail = strtolower($personName);
                $personEmail = preg_replace(['/\./', '/ /'], ['', '.'], $personEmail);
                $personEmail .= '@example.com';
                $user = User::factory([
                    'name' => $personName,
                    'email' => $personEmail,
                ])->create();
                $user->person()->save($person);
            }
        }

        $sessions = TrainingSession::factory(10)
            ->create()
        ;

        $sessionProgressBar = new ProgressBar($this->command->getOutput());
        $this->command->info('Seeding training sessions - each one gets 5 people and 5 training items');
        foreach ($sessionProgressBar->iterate($sessions) as $session) {
            // @var TrainingSession $session
            $session->trainees()->sync(Person::inRandomOrder()->limit(5)->get()->pluck('id')->all());
            $session->trainingItems()->sync(TrainingItem::inRandomOrder()->limit(5)->get()->pluck('id')->all());
        }

        Show::factory(10)
            ->has(Performance::factory(10))
            ->create()
        ;
    }
}
