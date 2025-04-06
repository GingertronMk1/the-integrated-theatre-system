<?php

namespace Database\Seeders;

use App\Models\Playwright;
use App\Models\Season;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\CrewRoleFactory;
use Database\Factories\PersonFactory;
use Database\Factories\PlaywrightFactory;
use Database\Factories\SeasonFactory;
use Database\Factories\ShowFactory;
use Database\Factories\VenueFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = 'admin@tits.test';
        if (! app()->environment('local')) {
            return;
        }
        if (! User::query()->where('email', '=', $adminEmail)->exists()) {
            $this->command->info('Creating admin user');
            User::create([
                'email' => $adminEmail,
                'password' => bcrypt(12345),
                'name' => 'Admin',
            ]);
        }

        $this->command->info('Creating Playwrights');
        (new PlaywrightFactory)->createMany(10);
        $this->command->info('Creating Seasons');
        (new SeasonFactory)->createMany(10);
        $this->command->info('Creating Venues');
        (new VenueFactory)->createMany(10);

        $this->command->info('Creating Shows');
        $showFactory = new ShowFactory;
        foreach (Playwright::all() as $playwright) {
            $this->command->withProgressBar(Season::all(), function ($season) use ($showFactory, $playwright) {
                $showFactory->create([
                    'playwright_id' => $playwright,
                    'season_id' => $season,
                ]);
            });
            $this->command->newLine();
        }

        $this->command->info('Creating People');
        (new PersonFactory)->createMany(1000);
        $this->command->info('Creating Crew Roles');
        (new CrewRoleFactory)->createMany(15);
    }
}
