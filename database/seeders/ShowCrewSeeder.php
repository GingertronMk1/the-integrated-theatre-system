<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShowCrewSeeder extends Seeder
{
    /**
     * @throws \JsonException
     * @throws \RuntimeException
     */
    public function run(): void
    {
        $this->call(ShowSeeder::class);
    }
}
