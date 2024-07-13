<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Person;
use App\Models\TrainingSession;
use App\View\Components\Form\TrainingSessionForm;
use Carbon\Carbon;
use Tests\TestCase;

class TrainingSessionControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingSession.index'));

        $response->assertOk();
    }

    public function testCreate(): void
    {
        $person = Person::factory()->create();
        $response = $this->actingAs($this->user)->get(route('trainingSession.create'));
        $response->assertStatus(200);

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingSessionForm::class,
            [
                'trainer_id' => $person->id,
                'happened_at' => Carbon::now(),
            ]
        );
        $formResponse->assertRedirect();
    }

    public function testShow(): void
    {
        $session = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->get(route('trainingSession.show', ['trainingSession' => $session]));
        $response->assertStatus(200);
    }

    public function testEdit(): void
    {
        $session = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->get(route('trainingSession.edit', ['trainingSession' => $session]));
        $response->assertStatus(200);

        $happenedAt = Carbon::createFromFormat('Y-m-d H:i:s', '2024-01-01 09:00:00');

        $formResponse = $this->getResponseForForm(
            $response,
            TrainingSessionForm::class,
            [
                'happened_at' => $happenedAt,
            ]
        );

        $formResponse->assertRedirect();

        $session->refresh();

        $this->assertEquals($happenedAt, $session->happened_at);
    }

    public function testDeleteSetsDelete(): void
    {
        $trainingSession = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('trainingSession.destroy', ['trainingSession' => $trainingSession]));
        $response->assertRedirect();
        $trainingSession->refresh();
        $this->assertNotNull($trainingSession->deleted_at);
    }
}
