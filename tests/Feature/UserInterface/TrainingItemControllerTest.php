<?php

namespace Tests\Feature\UserInterface;

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
}
