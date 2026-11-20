<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    /**
     * @throws \JsonException
     * @throws \RuntimeException
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PerformanceSeeder::class,
        ]);
    }
}
