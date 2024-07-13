<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Performance;
use App\Models\Show;
use App\Models\Venue;
use App\View\Components\Form\PerformanceForm;
use Carbon\Carbon;
use Tests\TestCase;

class ShowPerformanceControllerTest extends TestCase
{
    private Show $show;

    protected function setUp(): void
    {
        parent::setUp();
        $this->show = Show::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.performance.index', ['show' => $this->show]))
        ;
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $venue = Venue::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.performance.create', ['show' => $this->show]))
        ;
        $response->assertOk();
        $capacity = 1980;
        $formResponse = $this->getResponseForForm(
            $response,
            PerformanceForm::class,
            [
                'show_start' => Carbon::now(),
                'doors' => Carbon::now(),
                'venue_id' => $venue->id,
                'capacity' => $capacity,
            ],
        );
        $formResponse->assertRedirect();

        $this->show->refresh();
        $this->assertContains($capacity, $this->show->performances->pluck('capacity'));
    }

    public function testEdit(): void
    {
        $performance = $this->makePerformance();
        $response = $this
            ->actingAs($this->user)
            ->get(
                route(
                    'show.performance.edit',
                    [
                        'show' => $this->show,
                        'performance' => $performance,
                    ],
                ),
            )
        ;
        $response->assertOk();

        $formResponse = $this->getResponseForForm(
            $response,
            PerformanceForm::class,
            [
                'capacity' => 1,
            ],
            [
                'show_start' => $performance->show_start,
                'doors' => $performance->doors,
                'capacity' => $performance->capacity,
                'venue_id' => $performance->venue?->id,
            ]
        );

        $formResponse->assertRedirect();
    }

    public function testDestroy(): void
    {
        $performance = $this->makePerformance();
        $response = $this
            ->actingAs($this->user)
            ->delete(
                route(
                    'show.performance.destroy',
                    [
                        'show' => $this->show,
                        'performance' => $performance,
                    ],
                ),
            )
        ;
        $response->assertRedirect();
        $performance->refresh();
        $this->assertNotNull($performance->deleted_at);
    }

    private function makePerformance(): Performance
    {
        return Performance::factory()->state([
            'show_id' => $this->show->id,
        ])->create();
    }
}
