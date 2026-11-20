<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->venues() as $venue) {
            Venue::query()->firstOrCreate(['name' => $venue], ['address' => '', 'description' => '']);
        }
    }

    /** @return list<string> */
    private function venues(): array
    {
        return [
            'A barn in Lenton',
            'Bedlam Theatre',
            'Bevan Theatre',
            'Broughton High School',
            'C cubed',
            'C nova',
            'C soco',
            'C too',
            'C venues',
            'Cathedral Hall, Albany Street',
            'Cephas Cellar',
            'Co-op Arts Theatre',
            'Colston Hall',
            'Cripps Hall',
            'Cripps Hall Library',
            'Derby Hall Library',
            'Djanogly Terrace',
            'Djanogly Theatre',
            'Gilded Balloon',
            'Herriot Watt Building',
            'Hugh Stuart Library',
            'Infirmary Street, Greenside',
            'Jubilee Campus: Business School South Auditorum B52',
            'Lakeside Arts',
            'Lee Rosy\'s Tea Rooms',
            'Lincoln Library',
            'Malone Atrium',
            'Minack Theatre, Cornwall',
            'Monica Partridge Studio',
            'New Theatre',
            'New Theatre Backstage',
            'New Theatre Studio A',
            'New Theatre Studio A and B',
            'New Theatre Studio B',
            'Open Air, University Park Campus',
            'PLH',
            'Performing Arts Studio',
            'Pleasance Courtyard',
            'Portland Ballroom',
            'Portland CM04',
            'Portland Studio',
            'Royal Terrace, Greenside',
            'Rutland Hall',
            'Secret Location in Lenton',
            'Sherwood Library',
            'St Columba\'s by the Castle',
            'St Martin\'s Crypt',
            'Studio Live',
            'Sweet ECA',
            'Sweet Grassmarket',
            'The Den',
            'The Lacehouse',
            'The Lofthouse',
            'The Three Wheatsheaves',
            'The Zoo',
            'Trent Building',
            'Trent Building Courtyard',
            'Trent, Great Hall',
            'Trent, Performing Arts Studio',
            'Underbelly',
            'University of Glasgow',
            'Upload Festival',
            'Walled Garden',
            'YouTube',
            'ZOO',
            'ZOO Monkeyhouse',
            'ZOO Southside',
            'theSpace @ Surgeons\' Hall',
            'theSpaceUK Online',
            'unknown',
        ];
    }
}
