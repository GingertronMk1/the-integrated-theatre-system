<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        TrainingCategory::factory(10)
            ->has(TrainingItem::factory(10))
            ->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->person()->create([
            'name' => 'Test Person',
            'start_year' => 2007,
            'end_year' => 2017,
        ]);

        $progressBar = new ProgressBar($this->command->getOutput());

        $personJson = Storage::json('person-fixtures.json');

        $this->command->info('Seeding people - every other person gets a user attached to them');
        foreach ($progressBar->iterate($personJson) as $personIndex => $person) {
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
    }
}
