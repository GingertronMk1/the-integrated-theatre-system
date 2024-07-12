<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function testThatItShows(): void
    {
        $user = User::factory()->create();
        $request = $this->actingAs($user)->get(route('dashboard'));
        $request->assertStatus(200);
    }
}
