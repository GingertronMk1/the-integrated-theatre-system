<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Season;
use App\Models\Show;
use App\Models\Venue;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('show.index'));

        $response->assertSeeTextInOrder(Show::all()->take(10)->pluck('title')->toArray());
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('show.create'));
        $response->assertStatus(200);
    }

    public function testEdit(): void
    {
        $show = Show::factory()->create();
        $response = $this->actingAs($this->user)->get(route('show.edit', ['show' => $show]));
        $response->assertStatus(200);
    }

    public function testCreateStoresProperly(): void
    {
        $venue = Venue::factory()->create();
        $season = Season::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->post(route('show.store'), [
                'title' => 'test 1',
                'season_id' => (string) $season->id,
                'year' => 1997,
                'venue_id' => (string) $venue->id,
            ])
        ;
        $response->assertRedirectToRoute('show.index');
    }

    public function testShow(): void
    {
        $show = Show::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.show', ['show' => $show]))
        ;
        $response->assertOk();
    }

    public function testUpdateStoresProperly(): void
    {
        $description = 'This is the new description';

        $show = Show::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('show.update', ['show' => $show]), [
                'description' => $description,
            ])
        ;
        $response->assertRedirectToRoute('show.index');

        $show->refresh();

        $this->assertEquals($description, $show->description);
    }

    public function testDeleteSetsDelete(): void
    {
        $show = Show::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('show.destroy', ['show' => $show]));
        $response->assertRedirect();
        $show->refresh();
        $this->assertNotNull($show->deleted_at);
    }
}
