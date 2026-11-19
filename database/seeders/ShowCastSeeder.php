<?php

namespace Database\Seeders;

use App\Models\ShowCast;
use Illuminate\Database\Seeder;

class ShowCastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShowCast::factory()->create();
    }
}
