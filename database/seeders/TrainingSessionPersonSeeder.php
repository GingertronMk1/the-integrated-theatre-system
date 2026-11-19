<?php

namespace Database\Seeders;

use App\Models\TrainingSessionPerson;
use Illuminate\Database\Seeder;

class TrainingSessionPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TrainingSessionPerson::factory()->create();
    }
}
