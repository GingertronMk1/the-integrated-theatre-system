<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use Tests\TestCase;

class TrainingCategoryControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.index'),
        );

        $response->assertSeeTextInOrder(
            TrainingCategory::all()->take(10)->pluck('name')->toArray(),
        );
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.create'),
        );
        $response->assertStatus(200);
    }

    public function testCreateStoresProperly(): void
    {
        $name = 'test category 1';

        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->post(
            route('trainingCategory.store'),
            [
                'name' => $name,
                'advanced' => 1,
            ],
        );
        $response->assertRedirectToRoute('trainingCategory.index');

        $category = TrainingCategory::firstWhere('name', $name);
        $this->assertEquals(true, $category->advanced);
    }

    public function testUpdateStoresProperly(): void
    {
        $description = 'This is the new description';

        $category = TrainingCategory::factory()->create();

        $response = $this->actingAs($this->user)->put(
            route('trainingCategory.update', ['trainingCategory' => $category]),
            [
                'name' => $category->name,
                'description' => $description,
                'advanced' => $category->advanced,
            ],
        );
        $response->assertRedirectToRoute('trainingCategory.index');

        $category->refresh();

        $this->assertEquals($description, $category->description);
    }

    public function testShowShows(): void
    {
        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.show', ['trainingCategory' => $category]),
        );
        $response->assertOk();
    }

    public function testEditShows(): void
    {
        $category = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.edit', ['trainingCategory' => $category]),
        );
        $response->assertOk();
    }

    public function testCreateShows(): void
    {
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.create'),
        );
        $response->assertOk();
    }

    public function testDeleteSetsDelete(): void
    {
        $trainingCategory = TrainingCategory::factory()->create();
        $response = $this->actingAs($this->user)->delete(
            route('trainingCategory.destroy', [
                'trainingCategory' => $trainingCategory,
            ]),
        );
        $response->assertRedirect();
        $trainingCategory->refresh();
        $this->assertNotNull($trainingCategory->deleted_at);
    }
}
