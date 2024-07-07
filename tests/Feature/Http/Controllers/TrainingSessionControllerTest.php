<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Person;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Tests\TestCase;

class TrainingSessionControllerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingSession.index'));

        $response->assertOk();
    }

    public function test_create(): void
    {
        $response = $this->actingAs($this->user)->get(route('trainingSession.create'));
        $response->assertStatus(200);
    }

    public function test_create_stores_properly(): void
    {
        $person = Person::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->post(route('trainingSession.store'), [
                'trainer_id' => $person->id,
                'happened_at' => Carbon::now(),
            ]);
        $response->assertRedirect();
    }

    public function test_show(): void
    {
        $session = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->get(route('trainingSession.show', ['trainingSession' => $session]));
        $response->assertStatus(200);
    }

    public function test_edit(): void
    {
        $session = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->get(route('trainingSession.edit', ['trainingSession' => $session]));
        $response->assertStatus(200);
    }

    public function test_update_stores_properly(): void
    {
        $description = 'This is the new description';

        $session = TrainingSession::factory()->create();
        $happenedAt = Carbon::createFromFormat('Y-m-d H:i:s', '2024-01-01 09:00:00');

        $response = $this
            ->actingAs($this->user)
            ->put(route('trainingSession.update', ['trainingSession' => $session]), [
                'trainer_id' => $session->trainer_id,
                'happened_at' => $happenedAt,
            ]);
        $response->assertRedirectToRoute('trainingSession.index');

        $session->refresh();

        $this->assertEquals($happenedAt, $session->happened_at);
    }

    public function test_delete_sets_delete(): void
    {
        $trainingSession = TrainingSession::factory()->create();
        $response = $this->actingAs($this->user)->delete(route('trainingSession.destroy', ['trainingSession' => $trainingSession]));
        $response->assertRedirect();
        $trainingSession->refresh();
        $this->assertNotNull($trainingSession->deleted_at);
    }
}
