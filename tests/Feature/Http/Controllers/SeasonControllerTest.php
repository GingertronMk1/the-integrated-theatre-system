<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Season;
use Tests\TestCase;

class SeasonControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('season.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('season.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $newName = 'Test Season';
        $newColour = '#BAD455';
        $newDescription = 'Test description woooo';
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('season.store'),
                [
                    'name' => $newName,
                    'colour' => $newColour,
                    'description' => $newDescription,
                ],
            )
        ;
        $response->assertRedirect();
        $season = Season::where('name', $newName)->where('colour', $newColour)->where('description', $newDescription)->first();
        $this->assertNotNull($season);
    }

    public function testShow(): void
    {
        $season = Season::factory()->create();
        $response = $this->actingAs($this->user)->get(route('season.show', ['season' => $season]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $season = Season::factory()->create();
        $response = $this->actingAs($this->user)->get(route('season.edit', ['season' => $season]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $newColour = '#BAD455';
        $season = Season::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->put(
                route('season.update', ['season' => $season]),
                [
                    'colour' => $newColour,
                ],
            )
        ;
        $season->refresh();
        $this->assertEquals($newColour, $season->colour);
    }

    public function testDestroy(): void
    {
        $season = Season::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('season.destroy', ['season' => $season]));
        $response->assertRedirect();

        $season->refresh();
        $this->assertNotNull($season->deleted_at);
    }
}
