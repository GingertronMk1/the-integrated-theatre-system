<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Performance;
use App\Models\Show;
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

    public function test_index(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.performance.index', ['show' => $this->show]));
        $response->assertOk();
    }

    public function test_create(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.performance.create', ['show' => $this->show]));
        $response->assertOk();
    }

    public function test_store(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(
                route('show.performance.store', ['show' => $this->show]),
                [
                    'show_start' => Carbon::now(),
                    'doors' => Carbon::now(),
                    'venue' => 'venue',
                    'capacity' => 100,
                ]
            );
        $response->assertRedirect();
    }

    public function test_edit(): void
    {
        $performance = $this->makePerformance();
        $response = $this
            ->actingAs($this->user)
            ->get(
                route(
                    'show.performance.index',
                    [
                        'show' => $this->show,
                        'performance' => $performance,
                    ]
                )
            );
        $response->assertOk();
    }

    public function test_update(): void
    {
        $performance = $this->makePerformance();
        $response = $this
            ->actingAs($this->user)
            ->put(
                route(
                    'show.performance.update',
                    [
                        'show' => $this->show,
                        'performance' => $performance,
                    ]
                ),
                [
                    'capacity' => 100,
                ]
            );
        $response->assertRedirect();
        $performance->refresh();
        $this->assertEquals(100, $performance->capacity);
    }

    public function test_destroy(): void
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
                    ]
                )
            );
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
