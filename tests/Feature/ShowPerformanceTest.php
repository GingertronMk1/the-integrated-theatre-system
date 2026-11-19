<?php

use App\Models\Performance;
use App\Models\Show;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;

test('a show returns its performances ordered by start time', function () {
    $show = Show::factory()->create();
    $venue = Venue::factory()->create();
    foreach (['2026-06-03 19:30:00', '2026-06-01 19:30:00', '2026-06-02 19:30:00'] as $start) {
        Performance::factory()->for($show)->for($venue)->create(['show_start' => $start]);
    }

    $expected = ['2026-06-01 19:30:00', '2026-06-02 19:30:00', '2026-06-03 19:30:00'];

    expect($show->performances()->pluck('show_start')->all())->toBe($expected)
        ->and(Show::query()->with('performances')->findOrFail($show->id)->performances->pluck('show_start')->all())->toBe($expected);
});

test('a show exposes first and last performance starts without loading the relationship', function () {
    $show = Show::factory()->create();
    $venue = Venue::factory()->create();
    Performance::factory()->for($show)->for($venue)->create(['show_start' => '2026-06-03 19:30:00']);
    Performance::factory()->for($show)->for($venue)->create(['show_start' => '2026-06-01 19:30:00']);
    Performance::factory()->for($venue)->create(['show_start' => '2025-01-01 19:30:00']);

    $show = Show::query()->findOrFail($show->id);

    expect($show->first_performance_start)->toBe('2026-06-01 19:30:00')
        ->and($show->last_performance_start)->toBe('2026-06-03 19:30:00')
        ->and($show->relationLoaded('performances'))->toBeFalse();
});

test('performance start attributes use already loaded performances without further queries', function () {
    $show = Show::factory()->create();
    $venue = Venue::factory()->create();
    Performance::factory()->for($show)->for($venue)->create(['show_start' => '2026-06-03 19:30:00']);
    Performance::factory()->for($show)->for($venue)->create(['show_start' => '2026-06-01 19:30:00']);
    $show = Show::query()->with('performances')->findOrFail($show->id);

    DB::enableQueryLog();
    DB::flushQueryLog();

    expect($show->first_performance_start)->toBe('2026-06-01 19:30:00')
        ->and($show->last_performance_start)->toBe('2026-06-03 19:30:00')
        ->and(DB::getQueryLog())->toBeEmpty();

    DB::disableQueryLog();
});

test('performance start attributes are null when a show has no performances', function () {
    $show = Show::factory()->create();

    expect($show->first_performance_start)->toBeNull()
        ->and($show->last_performance_start)->toBeNull();

    $show->load('performances');

    expect($show->first_performance_start)->toBeNull()
        ->and($show->last_performance_start)->toBeNull();
});

test('a performance with an unset start yields null for both attributes', function () {
    $show = Show::factory()->create();
    Performance::factory()->for($show)->create(['show_start' => null]);

    expect($show->first_performance_start)->toBeNull()
        ->and($show->last_performance_start)->toBeNull();
});
