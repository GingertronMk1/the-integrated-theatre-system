<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getSeasons() as $season) {
            Season::query()->firstOrCreate([
                'name' => $season,
                'description' => $season,
                'colour' => '#000000',
            ]);
        }
    }

    /** @return list<string> */
    private function getSeasons(): array
    {
        return [
            'In House',
            'StuFF',
            'Fringe',
            'Edinburgh',
            'External',
            'Postgrads',
            'Lakeside',
            'UNCUT',
            'Online',
            'Studio',
            'Unscripted',
            'Fundraiser',
            'Creatives',

        ];
    }
}
