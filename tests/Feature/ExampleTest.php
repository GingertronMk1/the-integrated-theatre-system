<?php

use App\Models\Performance;
use App\Models\Person;
use App\Models\Show;
use App\Models\User;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('the welcome page shows current theatre totals to guests', function () {
    $shows = Show::factory()->count(2)->create();
    Performance::factory()->count(3)->for($shows->first())->create();
    Person::factory()->count(4)->create();

    $this->get(route('home'))
        ->assertOk()
        ->assertViewHas('showCount', 2)
        ->assertViewHas('performanceCount', 3)
        ->assertViewHas('peopleCount', 4)
        ->assertSeeTextInOrder(['Shows', '2', 'Performances', '3', 'People', '4'])
        ->assertSee('Log in');
});

test('signed-in users can reach their dashboard from the welcome page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('home'))->assertOk()->assertSee(route('dashboard'))->assertSee('Dashboard');
});
