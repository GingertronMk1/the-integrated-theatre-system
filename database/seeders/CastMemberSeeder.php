<?php

namespace Database\Seeders;

use App\Models\CastMember;
use App\Models\Show;
use Illuminate\Database\Seeder;

class CastMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Show::query()->lazy(10)->each(function (Show $show) {
            CastMember::factory(rand(2, 25))->for($show)->create();
        });
    }
}
