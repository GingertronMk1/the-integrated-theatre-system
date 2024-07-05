<?php

namespace Tests\Feature\UserInterface;

use App\Models\Show;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('show.index'));

        $response->assertSeeTextInOrder(Show::all()->take(10)->pluck('title')->toArray());
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->get(route('show.create'));
        $response->assertStatus(200);
    }

    public function test_edit(): void
    {
        $show = Show::factory()->create();
        $response = $this->actingAs($this->user)->get(route('show.edit', ['show' => $show]));
        $response->assertStatus(200);
    }

    public function test_create_stores_properly(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post(route('show.store'), [
                'title' => 'test 1',
                'season' => 'test 1',
                'year' => 1997,
            ]);
        $response->assertRedirectToRoute('show.index');
    }

    public function test_show(): void
    {
        $show = Show::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->get(route('show.show', ['show' => $show]));
        $response->assertOk();
    }

    public function test_update_stores_properly(): void
    {
        $description = 'This is the new description';

        $show = Show::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('show.update', ['show' => $show]), [
                'description' => $description,
            ]);
        $response->assertRedirectToRoute('show.index');

        $show->refresh();

        $this->assertEquals($description, $show->description);
    }

    public function test_delete_sets_delete(): void
    {
        $show = Show::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('show.destroy', ['show' => $show]));
        $response->assertRedirect();
        $show->refresh();
        $this->assertNotNull($show->deleted_at);
    }
}
