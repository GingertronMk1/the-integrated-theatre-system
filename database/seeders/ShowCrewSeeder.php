<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShowCrewSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ShowSeeder::class);
    }
}
