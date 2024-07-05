<?php

namespace Tests\Feature\UserInterface;

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

        $session = TrainingSession::factory()->create();
        $response = $this
            ->actingAs($this->user)
            ->post(route('trainingSession.store'), [
                'person_id' => $person->id,
                'happened_at' => Carbon::now(),
            ]);
        $response->assertRedirectToRoute('trainingSession.show');
    }

    public function test_update_stores_properly(): void
    {
        $description = 'This is the new description';

        $session = TrainingSession::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->put(route('trainingSession.update', ['trainingSession' => $session]), [
                'name' => $session->name,
                'description' => $description,
                'advanced' => $session->advanced,
            ]);
        $response->assertRedirectToRoute('trainingSession.index');

        $session->refresh();

        $this->assertEquals($description, $session->description);
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
