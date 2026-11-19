<?php

use App\Models\Performance;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Role;
use App\Models\Season;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use App\Models\Ticket;
use App\Models\TrainingCategory;
use App\Models\TrainingItem;
use App\Models\TrainingSession;
use App\Models\TrainingSessionPerson;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Model;

$resources = [
    'people' => [Person::class, 'people', 'start_year', '1999', ['start_year', 'end_year']],
    'roles' => [Role::class, 'roles', 'name', 'Stage manager', ['name']],
    'shows' => [Show::class, 'shows', 'name', 'The Tempest', ['name', 'playwright_id', 'season_id']],
    'cast' => [ShowCast::class, 'show-cast', 'role_name', 'Prospero', ['show_id', 'person_id', 'role_name']],
    'crew' => [ShowCrew::class, 'show-crew', 'notes', 'Backstage', ['show_id', 'person_id', 'role_id']],
    'venues' => [Venue::class, 'venues', 'name', 'Main theatre', ['name', 'address', 'description']],
    'seasons' => [Season::class, 'seasons', 'name', 'Spring', ['name', 'colour', 'description']],
    'playwrights' => [Playwright::class, 'playwrights', 'name', 'William Shakespeare', ['name', 'bio', 'external_links']],
    'performances' => [Performance::class, 'performances', 'capacity', 120, ['show_id', 'venue_id', 'capacity']],
    'tickets' => [Ticket::class, 'tickets', 'status', 'reserved', ['performance_id', 'status']],
    'training categories' => [TrainingCategory::class, 'training-categories', 'name', 'Technical', ['name']],
    'training items' => [TrainingItem::class, 'training-items', 'name', 'Lighting', ['name', 'training_category_id', 'dangerous']],
    'training sessions' => [TrainingSession::class, 'training-sessions', 'occurred_at', '2026-01-02 12:00:00', ['training_item_id', 'occurred_at']],
    'training participants' => [TrainingSessionPerson::class, 'training-session-people', 'type', 'trainer', ['training_session_id', 'person_id', 'type']],
];

test('a verified user can manage :dataset through the JSON endpoints', function (string $model, string $resource, string $field, mixed $value) {
    $this->actingAs(User::factory()->create());
    /** @var Model $example */
    $example = $model::factory()->create();
    $payload = collect($example->toArray())->except(['id', 'created_at', 'updated_at', 'deleted_at'])->all();
    if ($example instanceof Playwright) {
        $payload['external_links'] = ['website' => 'https://example.test'];
    }

    $this->getJson(route("api.v1.$resource.index"))->assertOk()->assertJsonFragment(['id' => $example->getKey()]);
    $response = $this->postJson(route("api.v1.$resource.store"), $payload)->assertCreated();
    $id = $response->json('data.id');
    $this->getJson(route("api.v1.$resource.show", $id))->assertOk()->assertJsonPath('data.id', $id);
    $this->patchJson(route("api.v1.$resource.update", $id), [$field => $value])->assertOk();
    $this->assertDatabaseHas($example->getTable(), ['id' => $id, $field => $value]);
    $this->deleteJson(route("api.v1.$resource.destroy", $id))->assertNoContent();
    $this->getJson(route("api.v1.$resource.show", $id))->assertNotFound();
})->with($resources);

test(':dataset requires its required fields', function (string $model, string $resource, string $field, mixed $value, array $required) {
    $this->actingAs(User::factory()->create());

    $this->postJson(route("api.v1.$resource.store"), [])->assertUnprocessable()->assertJsonValidationErrors($required);
})->with($resources);

test('unverified users cannot access domain endpoints', function () {
    $this->actingAs(User::factory()->unverified()->create());

    $this->getJson(route('api.v1.shows.index'))->assertForbidden();
});

test('a user account cannot be linked to two people', function () {
    $user = User::factory()->create();
    Person::factory()->for($user)->create();
    $this->actingAs(User::factory()->create());

    $this->postJson(route('api.v1.people.store'), ['user_id' => $user->id, 'start_year' => '2020', 'end_year' => '2024'])
        ->assertUnprocessable()->assertJsonValidationErrors(['user_id']);
});
