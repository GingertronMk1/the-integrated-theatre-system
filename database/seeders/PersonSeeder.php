<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getFirstNames() as $firstKey => $firstName) {
            foreach ($this->getSurnames() as $surKey => $surName) {
                $key = $firstKey + $surKey;
                Person::query()->firstOrCreate([
                    'name' => "{$firstName} {$surName}",
                    'start_year' => 2000 + $key % 10,
                    'end_year' => 2004 + $key % 10,
                ]);
            }
        }
    }

    /** @return list<string> */
    private function getFirstNames(): array
    {
        return [
            'Aisha',
            'Allie',
            'Apollo',
            'Boden',
            'Brody',
            'Caiden',
            'Celeste',
            'Chandler',
            'Chase',
            'Cleo',
            'Damari',
            'Emely',
            'Emilio',
            'Gabriel',
            'Hunter',
            'Isaiah',
            'Kaitlyn',
            'Kalani',
            'Katie',
            'Kelly',
            'Kylan',
            'Laylani',
            'Leonardo',
            'Lucian',
            'Monroe',
            'Paulina',
            'Rayna',
            'Ricardo',
            'Rohan',
            'Scott',
            'Teresa',
            'Thomas',
            'Xiomara',
            'Zainab',
        ];
    }

    /** @return list<string> */
    private function getSurnames(): array
    {
        return [
            'Bennett',
            'Browning',
            'Case',
            'Clarke',
            'Contreras',
            'English',
            'Gomez',
            'Graham',
            'Guevara',
            'Hall',
            'Herman',
            'Ingram',
            'Knapp',
            'Kramer',
            'Lara',
            'Larsen',
            'Leonard',
            'Lloyd',
            'Maddox',
            'McDowell',
            'McKenzie',
            'Meza',
            'Moran',
            'Nash',
            'Nguyen',
            'Noble',
            'Salazar',
            'Serrano',
            'Shepard',
            'Simon',
            'Sparks',
            'Trujillo',
            'Villanueva',
            'Wallace',
        ];
    }
}
