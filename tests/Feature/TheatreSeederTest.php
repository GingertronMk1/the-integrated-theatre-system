<?php

use App\Models\Person;
use App\Models\Show;
use App\Models\User;
use Carbon\CarbonImmutable;
use Database\Seeders\DatabaseSeeder;

test('the database seeder creates a connected theatre dataset', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Person::query()->count())->toBe(1156)
        ->and(Show::query()->count())->toBe(100)
        ->and(User::query()->where('email', 'admin@tits.test')->exists())->toBeTrue();

    $shows = Show::query()->with(['cast', 'crew', 'performances'])->get();

    foreach ($shows as $show) {
        expect($show->cast->count())->toBeGreaterThanOrEqual(5)->toBeLessThanOrEqual(20)
            ->and($show->cast->pluck('person_id')->unique())->toHaveCount($show->cast->count())
            ->and($show->crew->count())->toBeGreaterThanOrEqual(10)->toBeLessThanOrEqual(50)
            ->and($show->crew->pluck('person_id')->unique())->toHaveCount($show->crew->count())
            ->and($show->performances->count())->toBeGreaterThanOrEqual(3)->toBeLessThanOrEqual(5);

        $performances = $show->performances->sortBy('show_start')->values();
        $firstDate = CarbonImmutable::parse($performances->first()->show_start);

        foreach ($performances as $index => $performance) {
            expect($performance->show_start->toDateTimeString())->toBe($firstDate->addDays($index)->format('Y-m-d H:i:s'));
        }
    }
});
