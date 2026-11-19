<?php

namespace Database\Seeders;

use App\Models\Playwright;
use Illuminate\Database\Seeder;

class PlaywrightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getPlaywrights() as $playwright) {
            Playwright::query()->firstOrCreate([
                'name' => $playwright,
                'bio' => $playwright,
                'external_links' => '[]',
            ]);
        }
    }

    /** @return list<string> */
    private function getPlaywrights(): array
    {
        return [
            'William Shakespeare',
            'various',
            'Oscar Wilde',
            'Harold Pinter',
            'Samuel Beckett',
            'Arthur Miller',
            'Tom Stoppard',
            'Christopher Marlowe',
            'Peter Shaffer',
            'Alan Ayckbourn',
            'Eugène Ionesco',
            'Anton Chekhov',
            'Tara Anegada',
            'Henrik Ibsen',
            'Aristophanes',
            'Martin McDonagh',
            'Dennis Kelly',
            'Tennessee Williams',
            'Alan Bennett',
            'Emma White',
            'Emma Summerton',
            'Willy Russell',
            'Franz Kafka',
            'Bertolt Brecht',
            'Mark Ravenhill',
            'Joe Orton',
            'Euripides',
            'Max Frisch',
            'Adam H. Wells',
            'Philip Ridley',
            'Caryl Churchill',
            'Callum Walker',
            'Daniel McVey',
            'Cecilia Alexander',
            'Timberlake Wertenbaker',
            'Steven Berkoff',
            'Patrick Marber',
            'Federico García Lorca',
            'Jim Cartwright',
            'Jez Butterworth',
            'Simon Stephens',
            'Sam Shepard',
            'Nikki Hill',
            'Tom Proffitt',
            'F. Scott Fitzgerald',
            'Ben Macpherson',
            'Jonny Khan',
            'M Craig',
            'Ben Richards',
            'Sarah Kane',
            'Laura Wade',
            'George Bernard Shaw',
            'Eve Ensler',
            'Edward Albee',
            'Jean-Paul Sartre',
            'Anthony Burgess',
            'Dario Fo',
            'Sophocles',
            'Mike Bartlett',
            'Ian Sheard & Jamie Drew',
            'Jonathan Taylor Davies',
            'Bróccán Tyzack-Carlin',
            'Joe Strickland',
            'Ben Standish',
            'Hettie Rockell',
            'Molly Squires',
            'Holly Howell',
            'NNT Creatives',
            'Thomas Middleton and William Rowley',
            'James Saunders',
            'Kevin Buxton',
            'Gilbert & Sullivan',
            'Richard Davidson',

        ];
    }
}
