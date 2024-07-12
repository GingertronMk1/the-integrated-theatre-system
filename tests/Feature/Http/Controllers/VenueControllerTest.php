<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Venue;
use App\View\Components\Form\VenueForm;
use Symfony\Component\DomCrawler\Crawler;
use Tests\TestCase;

class VenueControllerTest extends TestCase
{
    private Venue $venue;

    protected function setUp(): void
    {
        parent::setUp();
        $this->venue = Venue::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('venue.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('venue.create'));
        $response->assertOk();

        $responseBody = new Crawler($response->baseResponse->getContent());
        $form = $this->getGenericForm($responseBody, VenueForm::class);
        $form->setValues([
            'name' => 'Test Venu',
            'location' => 'Test place',
            'location_additional' => fake()->paragraphs(3, true),
            'capacity' => 500,
        ]);
        $formResponse = $this->post($form->getUri(), $form->getValues());
        $formResponse->assertRedirect();
    }

    public function testShow(): void {}

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)->get(route('venue.edit', ['venue' => $this->venue]));
        $response->assertOk();

        $formResponse = $this->getResponseForForm(
            $response,
            VenueForm::class,
            [
                'name' => 'Test Venu',
                'location' => 'Test place',
                'location_additional' => fake()->paragraphs(3, true),
                'capacity' => 500,
            ]
        );
        $formResponse->assertRedirect();

        $this->venue->refresh();
        $this->assertEquals(500, $this->venue->capacity);
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)->delete(route('venue.destroy', ['venue' => $this->venue]));
        $response->assertRedirect();

        $this->venue->refresh();
        $this->assertNotNull($this->venue->deleted_at);
    }
}
