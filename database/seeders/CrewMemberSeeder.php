<?php

namespace Database\Seeders;

use App\Models\CrewMember;
use App\Models\Show;
use Illuminate\Database\Seeder;

class CrewMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Show::query()->lazy(10)->each(function (Show $show) {
            CrewMember::factory(rand(5, 25))->for($show)->create();
        });
    }
}
