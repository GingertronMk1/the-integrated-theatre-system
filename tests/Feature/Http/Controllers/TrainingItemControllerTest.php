<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use App\View\Components\Form\TrainingItemForm;
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
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingItem.create'));
        $response->assertStatus(200);

        $name = 'test item 1';

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingItemForm::class,
            [
                'name' => $name,
                'training_category_id' => $this->category->id,
            ]
        );

        $formResponse->assertRedirect();
    }

    public function testShow(): void
    {
        $item = TrainingItem::factory()->for($this->category)->create();
        $response = $this->actingAs($this->user)->get(route('trainingItem.show', ['trainingItem' => $item]));
        $response->assertOk();
    }

    public function testUpdateStoresProperly(): void
    {
        $item = TrainingItem::factory()->for($this->category)->create();
        $response = $this->actingAs($this->user)->get(route('trainingItem.edit', ['trainingItem' => $item]));
        $response->assertStatus(200);

        $description = 'This is the new description';

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingItemForm::class,
            [
                'description' => $description,
            ],
            [
                'name' => $item->name,
                'description' => $item->description,
                'training_category_id' => $this->category->id,
            ]
        );

        $formResponse->assertRedirect();

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
