<?php

use App\Models\User;

test('guests can visit the dashboard', function () {
    $response = $this->get(route('dashboard'));
    $response->assertOk()->assertSee('Log in')->assertSee('Theatre workspace');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('unverified users can visit the public dashboard', function () {
    $this->actingAs(User::factory()->unverified()->create());

    $this->get(route('dashboard'))->assertOk();
});
