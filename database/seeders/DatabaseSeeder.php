<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @throws \JsonException
     * @throws \RuntimeException
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'email' => 'admin@tits.test',
        ], [
            'name' => 'Admin',
            'password' => '12345',
        ]);
        $this->call(TheatreSeeder::class);
    }
}
