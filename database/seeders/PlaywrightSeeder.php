<?php

namespace Database\Seeders;

use App\Models\Playwright;
use Illuminate\Database\Seeder;

class PlaywrightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Playwright::factory(10)->create();
    }
}
