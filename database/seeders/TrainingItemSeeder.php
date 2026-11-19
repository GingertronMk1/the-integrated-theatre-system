<?php

namespace Database\Seeders;

use App\Models\TrainingItem;
use Illuminate\Database\Seeder;

class TrainingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrainingItem::factory()->create();
    }
}
