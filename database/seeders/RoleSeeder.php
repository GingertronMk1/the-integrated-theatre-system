<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getRoleNames() as $role) {
            Role::query()->firstOrCreate([
                'name' => $role,
            ]);
        }
    }

    /** @return list<string> */
    private function getRoleNames(): array
    {
        return [
            'Director',
            'Technical Operator',
            'Stage Manager',
            'Producer',
            'Lighting Designer',
            'Technical Director',
            'Sound Designer',
            'Set Designer',
            'Poster Designer',
            'Set Construction',
            'Assistant Director',
            'Publicity Manager',
            'Assistant Producer',
            'Assistant Stage Manager',
            'Publicity Assistant',
            'Writer',
            'Shadow Director',
            'Production Assistant',
            'Co-Director',
            'Musician',
            'Lighting',
            'Photographer',
            'Sound',
            'Venue Technician',
            'Set Assistant',
            'Costume Designer',
            'Publicity Designer',
            'Deputy Stage Manager',
            'Technician',
            'Costumes',
            'Designer',
            'Playwright',
            'Shadow Technical Director',
            'Video Designer',
            'Show Technician',
            'Co-Producer',
            'Creative Assistant',
            'Backstage',
            'Publicity',
            'Musical Director',
        ];
    }
}
