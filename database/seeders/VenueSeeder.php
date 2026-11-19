<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getVenues() as $venue) {
            Venue::query()->firstOrCreate([
                'name' => $venue,
                'address' => $venue,
                'description' => $venue,
            ]);
        }
    }

    /** @return list<string> */
    private function getVenues(): array
    {
        return [
            'New Theatre',
            'New Theatre Studio A',
            'Djanogly Theatre',
            'Trent, Great Hall',
            'YouTube',
            'Portland Studio',
            'Studio Live',
            'unknown',
            'Trent, Performing Arts Studio',
            'ZOO Monkeyhouse',
            'Bedlam Theatre',
            'The Zoo',
            'Lincoln Library',
            'C soco',
            'Royal Terrace, Greenside',
            'Infirmary Street, Greenside',
            "St Columba's by the Castle",
            'C too',
            'The Den',
            'Open Air, University Park Campus',
            "Lee Rosy's Tea Rooms",
            'New Theatre Studio B',
            'Sherwood Library',
            'Performing Arts Studio',
        ];
    }
}
