<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = 'admin@tits.test';
        if (app()->environment('local')) {
            if (!User::query()->where('email', '=', $adminEmail)->exists()) {
                User::create([
                    'email' => $adminEmail,
                    'password' => bcrypt(12345),
                    'name' => 'Admin',
                ]);
            }
        }
        // User::factory(10)->create();
    }
}
