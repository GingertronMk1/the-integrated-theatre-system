<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Season;
use App\View\Components\Form\SeasonForm;
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
        $formResponse = $this->getResponseForForm(
            $response,
            SeasonForm::class,
            [
                'name' => 'Test Season',
                'colour' => '#B4D455',
                'description' => fake()->paragraphs(3, true),
            ]
        );

        $formResponse->assertRedirect();
    }

    public function testShow(): void
    {
        $season = Season::factory()->create();
        $response = $this->actingAs($this->user)->get(route('season.show', ['season' => $season]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $initialSeasonAttrs = [
            'name' => 'Test Season',
            'colour' => '#B4D455',
            'description' => fake()->paragraphs(3, true),
        ];
        $initialSeason = Season::create($initialSeasonAttrs);
        $newName = 'Edited Test Season';
        $response = $this->actingAs($this->user)->get(route('season.edit', ['season' => $initialSeason]));
        $response->assertOk();

        $formResponse = $this->getResponseForForm(
            $response,
            SeasonForm::class,
            [
                'name' => $newName,
            ],
            $initialSeasonAttrs
        );
        $formResponse->assertRedirect();

        $initialSeason->refresh();
        $this->assertEquals($newName, $initialSeason->name);
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
