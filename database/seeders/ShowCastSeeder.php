<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShowCastSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ShowSeeder::class);
    }
}
