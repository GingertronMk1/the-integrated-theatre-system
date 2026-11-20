<?php

use App\Models\Person;
use App\Models\Show;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PersonSeeder;

test('the database seeder imports credited productions from the theatre archive', function () {
    $this->seed(DatabaseSeeder::class);

    $show = Show::query()->where('name', "A Doll's House")->where('year', '2000')->firstOrFail();
    $unknown = Show::query()->where('name', 'The Hush')->where('year', '2000')->firstOrFail();
    $person = Person::query()->where('name', 'Gareth Bunn')->firstOrFail();
    $returningPerson = Person::query()->where('name', 'James Erskine')->firstOrFail();

    expect(Show::query()->count())->toBeGreaterThan(1000)
        ->and($show->playwright->name)->toBe('Henrik Ibsen')
        ->and($unknown->playwright->name)->toBe('Unknown')
        ->and($person->start_year)->toBe('1972')
        ->and($person->end_year)->toBe('1972')
        ->and($person->cast()->exists())->toBeTrue()
        ->and($returningPerson->start_year)->toBe('1998')
        ->and($returningPerson->end_year)->toBe('2001')
        ->and(User::query()->where('email', 'admin@tits.test')->exists())->toBeTrue();
});

test('person seeding updates the credited year range without duplicating people', function () {
    $person = Person::factory()->create(['name' => 'James Erskine', 'start_year' => '1900', 'end_year' => '1900']);

    $this->seed(PersonSeeder::class);
    $this->seed(PersonSeeder::class);

    expect($person->fresh()->start_year)->toBe('1998')
        ->and($person->fresh()->end_year)->toBe('2001')
        ->and(Person::query()->where('name', 'James Erskine')->count())->toBe(1);
});
