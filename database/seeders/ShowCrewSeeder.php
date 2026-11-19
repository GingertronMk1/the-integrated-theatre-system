<?php

namespace Database\Seeders;

use App\Models\ShowCrew;
use Illuminate\Database\Seeder;

class ShowCrewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShowCrew::factory()->create();
    }
}
