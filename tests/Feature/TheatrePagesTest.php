<?php

use App\Models\Performance;
use App\Models\Person;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\TrainingItem;
use App\Models\User;

it('allows guests to browse the theatre pages', function () {
    $cast = ShowCast::factory()->create();

    foreach (['shows.index', 'performances.index', 'people.index', 'training.index'] as $route) {
        $this->get(route($route))->assertOk()->assertSee('Log in');
    }

    $this->get(route('shows.show', $cast->show))->assertOk()->assertSee($cast->show->name);
});

it('shows the theatre records in the browser', function () {
    $cast = ShowCast::factory()->create(['role_name' => 'Hamlet']);
    $performance = Performance::factory()->for($cast->show)->create(['show_start' => '2026-06-12 19:00:00']);
    $person = Person::factory()->create(['name' => 'Alex Player']);
    $training = TrainingItem::factory()->create(['name' => 'Lighting safety', 'dangerous' => true]);
    $this->actingAs(User::factory()->create());

    $this->get(route('dashboard'))->assertOk()->assertSee($cast->show->name);
    $this->get(route('shows.index'))->assertOk()->assertSee($cast->show->name);
    $this->get(route('shows.show', $cast->show))->assertOk()->assertSee('Hamlet')->assertSee('2026-06-12 19:00:00');
    $upcoming = Performance::factory()->for($cast->show)->create(['show_start' => now()->addDay()]);
    $this->get(route('performances.index'))->assertOk()->assertSee($upcoming->venue->name);
    $this->get(route('people.index'))->assertOk()->assertSee($person->name);
    $this->get(route('training.index'))->assertOk()->assertSee($training->name)->assertSee('Hazardous');
});

it('shows helpful empty states', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('shows.index'))->assertOk()->assertSee('No past shows have been added yet.');
    $this->get(route('performances.index'))->assertOk()->assertSee('No upcoming shows have been added yet.');
    $this->get(route('people.index'))->assertOk()->assertSee('No people have been added yet.');
    $this->get(route('training.index'))->assertOk()->assertSee('No training items have been added yet.');
});

it('separates archived shows from upcoming shows by their performance dates', function () {
    $this->travelTo(now()->startOfSecond());
    $archived = Show::factory()->create(['name' => 'Archived production']);
    Performance::factory()->for($archived)->create(['show_start' => now()->subDays(2)]);
    Performance::factory()->for($archived)->create(['show_start' => now()->subDay()]);
    $upcoming = Show::factory()->create(['name' => 'Upcoming production']);
    $past = Performance::factory()->for($upcoming)->create(['show_start' => now()->subDay()]);
    $future = Performance::factory()->for($upcoming)->create(['show_start' => now()->addDay()]);
    Performance::factory()->for($upcoming)->create(['show_start' => now()->addDays(2)]);
    $undated = Show::factory()->create(['name' => 'Undated production']);
    Performance::factory()->for($undated)->create(['show_start' => null]);
    Show::factory()->create(['name' => 'Unscheduled production']);
    $deletedFuture = Performance::factory()->for($archived)->create(['show_start' => now()->addDay()]);
    $deletedFuture->delete();

    $this->get(route('shows.index'))->assertOk()->assertSee('Archived production')
        ->assertDontSee('Upcoming production')->assertDontSee('Undated production')->assertDontSee('Unscheduled production');
    $this->get(route('performances.index'))->assertOk()->assertSee('Upcoming production')
        ->assertDontSee('Archived production')->assertDontSee('Undated production')->assertDontSee('Unscheduled production')
        ->assertSee(route('bookings.create', $future))->assertDontSee(route('bookings.create', $past));
    $this->get(route('home'))->assertOk()->assertSee('Archived production');
});

it('serves the show lists at their public paths', function () {
    $this->get('/shows/archive')->assertOk()->assertSee('The show archive');
    $this->get('/shows/upcoming')->assertOk()->assertSee('Upcoming shows');
    $this->get(route('home'))->assertOk()->assertSee('href="'.url('/shows/archive').'"', false)
        ->assertSee('href="'.url('/shows/upcoming').'"', false);
});
