<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use Tests\TestCase;

class TrainingItemControllerTest extends TestCase
{
    private TrainingCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = TrainingCategory::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingItem.index'));

        $response->assertSeeTextInOrder(TrainingItem::all()->take(10)->pluck('name')->toArray());
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingItem.create'));
        $response->assertStatus(200);
    }

    public function testEdit(): void
    {
        $item = TrainingItem::factory()->for($this->category)->create();
        $response = $this->actingAs($this->user)->get(route('trainingItem.edit', ['trainingItem' => $item]));
        $response->assertStatus(200);
    }

    public function testCreateStoresProperly(): void
    {
        $name = 'test item 1';

        $response = $this
            ->actingAs($this->user)
            ->post(route('trainingItem.store'), [
                'name' => $name,
                'training_category_id' => $this->category->id,
            ])
        ;
        $response->assertRedirectToRoute('trainingItem.index');

        $item = TrainingItem::firstWhere('name', $name);
        $this->assertEquals($this->category->id, $item->trainingCategory->id);
    }

    public function testShow(): void
    {
        $item = TrainingItem::factory()->for($this->category)->create();
        $response = $this->actingAs($this->user)->get(route('trainingItem.show', ['trainingItem' => $item]));
        $response->assertOk();
    }

    public function testUpdateStoresProperly(): void
    {
        $description = 'This is the new description';

        $item = TrainingItem::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('trainingItem.update', ['trainingItem' => $item]), [
                'description' => $description,
            ])
        ;
        $response->assertRedirectToRoute('trainingItem.index');

        $item->refresh();

        $this->assertEquals($description, $item->description);
    }

    public function testDeleteSetsDelete(): void
    {
        $trainingItem = TrainingItem::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('trainingItem.destroy', ['trainingItem' => $trainingItem]));
        $response->assertRedirect();
        $trainingItem->refresh();
        $this->assertNotNull($trainingItem->deleted_at);
    }
}
