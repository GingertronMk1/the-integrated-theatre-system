<?php

namespace Database\Seeders;

use App\Models\CrewRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrewRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Director' => 'Directs the show',
            'Producer' => 'Makes the show possible',
            'Technical Director' => 'In charge of the lights and sounds',
            'Lighting Designer' => 'Makes it so you can see the show',
            'Sound Designer' => 'Makes it so you can hear the show',
        ];

        foreach ($roles as $role => $description) {
            CrewRole::query()->create([
                'name' => $role,
                'description' => $description,
            ]);
        }

        CrewRole::factory(10)->create();
    }
}
