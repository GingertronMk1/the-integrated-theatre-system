<?php

use App\Models\Performance;
use App\Models\Show;
use App\Models\User;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('the welcome page shows upcoming performances and recent productions to guests', function () {
    $show = Show::factory()->create(['name' => 'The Tempest']);
    $performance = Performance::factory()->for($show)->create(['show_start' => now()->addDay()]);
    $pastPerformance = Performance::factory()->create(['show_start' => now()->subDay()]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('The Tempest')
        ->assertSee(route('bookings.create', $performance))
        ->assertDontSee(route('bookings.create', $pastPerformance))
        ->assertSee('Log in');
});

test('signed-in users can reach their dashboard from the welcome page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('home'))->assertOk()->assertSee(route('dashboard'))->assertSee('Dashboard');
});
