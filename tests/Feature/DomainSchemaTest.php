<?php

use App\Filament\Resources\Shows\Pages\CreateShow;
use App\Filament\Resources\Shows\Pages\EditShow;
use App\Filament\Resources\Shows\RelationManagers\CastRelationManager;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use App\Models\Ticket;
use App\Models\TrainingSessionPerson;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('domain records persist with their relationships', function () {
    $cast = ShowCast::factory()->create();
    $crew = ShowCrew::factory()->create();
    $ticket = Ticket::factory()->create();
    $attendance = TrainingSessionPerson::factory()->create();
    $person = Person::factory()->for(User::factory())->create();

    expect(Str::isUuid($cast->id))->toBeTrue()
        ->and($cast->show->season)->not->toBeNull()
        ->and($cast->person)->not->toBeNull()
        ->and($crew->role)->not->toBeNull()
        ->and($ticket->performance->venue)->not->toBeNull()
        ->and($attendance->trainingSession->trainingItem->trainingCategory)->not->toBeNull()
        ->and($person->user->person->is($person))->toBeTrue();
});

test('a show can be created in the admin panel', function () {
    $season = Season::factory()->create();
    $playwright = Playwright::factory()->create();
    $this->actingAs(User::factory()->create());

    Livewire::test(CreateShow::class)
        ->fillForm([
            'name' => 'Hamlet',
            'season_id' => $season->id,
            'playwright_id' => $playwright->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('shows', ['name' => 'Hamlet', 'season_id' => $season->id]);
});

test('domain endpoints require authentication', function () {
    $this->getJson(route('api.v1.people.index'))->assertUnauthorized();
});

test('domain endpoints validate and update records', function () {
    $this->actingAs(User::factory()->create());
    $cast = ShowCast::factory()->create();

    $this->getJson(route('api.v1.show-cast.show', $cast))->assertOk()->assertJsonPath('data.id', $cast->id);
    $this->patchJson(route('api.v1.show-cast.update', $cast), ['role_name' => 'Hamlet'])->assertOk();
    $this->assertDatabaseHas('show_cast', ['id' => $cast->id, 'role_name' => 'Hamlet']);
    $this->postJson(route('api.v1.tickets.store'), ['performance_id' => $cast->id, 'status' => 'invalid'])
        ->assertUnprocessable()->assertJsonValidationErrors(['performance_id', 'status']);
});

test('cast members can be added to a show from its relation manager', function () {
    $show = Show::factory()->create();
    $person = Person::factory()->create();
    $this->actingAs(User::factory()->create());

    Livewire::test(CastRelationManager::class, [
        'ownerRecord' => $show,
        'pageClass' => EditShow::class,
    ])
        ->callAction(TestAction::make('create')->table(), [
            'person_id' => $person->id,
            'role_name' => 'Hamlet',
        ])
        ->assertHasNoActionErrors();

    $this->assertDatabaseHas('show_cast', ['show_id' => $show->id, 'person_id' => $person->id, 'role_name' => 'Hamlet']);
});

test('an administrator can create a user with a hashed password', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ManageUsers::class)
        ->callAction(CreateAction::class, [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'long-enough-password',
        ])
        ->assertHasNoActionErrors();

    $user = User::where('email', 'new@example.com')->firstOrFail();
    expect(Hash::check('long-enough-password', $user->password))->toBeTrue();
});
