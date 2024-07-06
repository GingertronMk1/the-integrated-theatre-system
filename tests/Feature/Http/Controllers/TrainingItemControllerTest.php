<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use Tests\TestCase;

class TrainingItemControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingItem.index'));

        $response->assertSeeTextInOrder(TrainingItem::all()->take(10)->pluck('name')->toArray());
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingItem.create'));
        $response->assertStatus(200);
    }

    public function test_create_stores_properly(): void
    {
        $name = 'test item 1';

        $category = TrainingCategory::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->post(route('trainingItem.store'), [
                'name' => $name,
                'training_category_id' => $category->id,
            ]);
        $response->assertRedirectToRoute('trainingItem.index');

        $item = TrainingItem::firstWhere('name', $name);
        $this->assertEquals($category->id, $item->trainingCategory->id);
    }

    public function test_update_stores_properly(): void
    {
        $description = 'This is the new description';

        $item = TrainingItem::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('trainingItem.update', ['trainingItem' => $item]), [
                'description' => $description,
            ]);
        $response->assertRedirectToRoute('trainingItem.index');

        $item->refresh();

        $this->assertEquals($description, $item->description);
    }

    public function test_delete_sets_delete(): void
    {
        $trainingItem = TrainingItem::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('trainingItem.destroy', ['trainingItem' => $trainingItem]));
        $response->assertRedirect();
        $trainingItem->refresh();
        $this->assertNotNull($trainingItem->deleted_at);
    }
}
