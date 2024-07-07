<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use Tests\TestCase;

class TrainingCategoryControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.index')
        );

        $response->assertSeeTextInOrder(
            TrainingCategory::all()->take(10)->pluck('name')->toArray()
        );
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.create')
        );
        $response->assertStatus(200);
    }

    public function test_create_stores_properly(): void
    {
        $name = 'test category 1';

        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->post(
            route('trainingCategory.store'),
            [
                'name' => $name,
                'advanced' => 1,
            ]
        );
        $response->assertRedirectToRoute('trainingCategory.index');

        $category = TrainingCategory::firstWhere('name', $name);
        $this->assertEquals(true, $category->advanced);
    }

    public function test_update_stores_properly(): void
    {
        $description = 'This is the new description';

        $category = TrainingCategory::factory()->create();

        $response = $this->actingAs($this->user)->put(
            route('trainingCategory.update', ['trainingCategory' => $category]),
            [
                'name' => $category->name,
                'description' => $description,
                'advanced' => $category->advanced,
            ]
        );
        $response->assertRedirectToRoute('trainingCategory.index');

        $category->refresh();

        $this->assertEquals($description, $category->description);
    }

    public function test_show_shows(): void
    {
        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.show', ['trainingCategory' => $category])
        );
        $response->assertOk();
    }

    public function test_edit_shows(): void
    {
        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.edit', ['trainingCategory' => $category])
        );
        $response->assertOk();
    }

    public function test_create_shows(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.create')
        );
        $response->assertOk();
    }

    public function test_delete_sets_delete(): void
    {
        $trainingCategory = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->delete(
            route('trainingCategory.destroy', [
                'trainingCategory' => $trainingCategory,
            ])
        );
        $response->assertRedirect();
        $trainingCategory->refresh();
        $this->assertNotNull($trainingCategory->deleted_at);
    }
}
