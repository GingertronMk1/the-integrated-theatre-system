<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use App\View\Components\Form\TrainingCategoryForm;
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

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingCategoryForm::class,
            [
                'name' => 'test',
                'advanced' => true,
            ]
        );

        $formResponse->assertRedirect();
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
        $category = TrainingCategory::create([
            'name' => 'test name',
            'description' => 'awooga',
            'advanced' => true
        ]);
        $response = $this->actingAs($this->user)->get(
            route('trainingCategory.edit', ['trainingCategory' => $category]),
        );
        $response->assertOk();

        $description = 'This is the new description';

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingCategoryForm::class,
            [
                'description' => $description,
            ],
            [
                'name' => $category->name,
                'description' => $category->description,
                'advanced' => $category->advanced,
            ],
        );

        $formResponse->assertRedirectToRoute('trainingCategory.index');

        $category->refresh();

        $this->assertEquals($description, $category->description);
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
