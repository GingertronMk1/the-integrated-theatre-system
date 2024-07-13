<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Season;
use App\Models\Show;
use App\Models\Venue;
use App\View\Components\Form\ShowForm;
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
        $venue = Venue::factory()->create();
        $season = Season::factory()->create();
        $response = $this->actingAs($this->user)->get(route('show.edit', ['show' => $show]));
        $response->assertStatus(200);

        $showTitle = 'test 1';

        $formResponse = $this->getResponseForForm(
            $response,
            ShowForm::class,
            [
                'title' => $showTitle,
                'season_id' => (string) $season->id,
                'year' => 1997,
                'venue_id' => (string) $venue->id,
            ]
        );

        $formResponse->assertRedirect();

        $season->refresh();
        $venue->refresh();

        $this->assertContains($showTitle, $season->shows->pluck('title'));
        $this->assertContains($showTitle, $venue->shows->pluck('title'));
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
        $initialAttrs = [
            'title' => 'wahoo',
            'description' => 'awooga',
        ];
        $show = Show::factory()->state(fn () => $initialAttrs)->create();

        $newDescription = 'This is the new description';

        $response = $this->actingAs($this->user)->get(route('show.edit', ['show' => $show]));

        $formResponse = $this->getResponseForForm(
            $response,
            ShowForm::class,
            [
                'description' => $newDescription,
            ],
            $initialAttrs
        );

        $formResponse->assertRedirect();

        $show->refresh();

        $this->assertEquals($newDescription, $show->description);
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
