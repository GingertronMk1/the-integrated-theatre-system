<?php

use App\Models\Performance;
use App\Models\Person;
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
    $performance = Performance::factory()->for($cast->show)->create(['show_start' => 'Friday 7pm']);
    $person = Person::factory()->create(['name' => 'Alex Player']);
    $training = TrainingItem::factory()->create(['name' => 'Lighting safety', 'dangerous' => true]);
    $this->actingAs(User::factory()->create());

    $this->get(route('dashboard'))->assertOk()->assertSee($cast->show->name);
    $this->get(route('shows.index'))->assertOk()->assertSee($cast->show->name);
    $this->get(route('shows.show', $cast->show))->assertOk()->assertSee('Hamlet')->assertSee('Friday 7pm');
    $this->get(route('performances.index'))->assertOk()->assertSee($performance->venue->name);
    $this->get(route('people.index'))->assertOk()->assertSee($person->name);
    $this->get(route('training.index'))->assertOk()->assertSee($training->name)->assertSee('Hazardous');
});

it('shows helpful empty states', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('shows.index'))->assertOk()->assertSee('No shows have been added yet.');
    $this->get(route('performances.index'))->assertOk()->assertSee('No performances have been added yet.');
    $this->get(route('people.index'))->assertOk()->assertSee('No people have been added yet.');
    $this->get(route('training.index'))->assertOk()->assertSee('No training items have been added yet.');
});
