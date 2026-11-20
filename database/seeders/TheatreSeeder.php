<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TheatreSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PerformanceSeeder::class,
        ]);
    }
}
