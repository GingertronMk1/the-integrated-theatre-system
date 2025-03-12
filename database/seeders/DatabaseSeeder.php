<?php

namespace Database\Seeders;

use App\Models\Playwright;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\PlaywrightFactory;
use Database\Factories\SeasonFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = 'admin@tits.test';
        if (!app()->environment('local')) {
            return;
        }
        if (! User::query()->where('email', '=', $adminEmail)->exists()) {
            User::create([
                'email' => $adminEmail,
                'password' => bcrypt(12345),
                'name' => 'Admin',
            ]);
        }

        (new PlaywrightFactory)->createMany(10);
        (new SeasonFactory)->createMany(10);
    }
}
