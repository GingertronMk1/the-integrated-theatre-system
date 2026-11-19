<?php

use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\RelationManagers\TrainingSessionPeopleRelationManager;
use App\Filament\Resources\Performances\Pages\EditPerformance;
use App\Filament\Resources\Performances\Pages\ListPerformances;
use App\Filament\Resources\Performances\RelationManagers\TicketsRelationManager;
use App\Filament\Resources\Playwrights\Pages\EditPlaywright;
use App\Filament\Resources\Playwrights\Pages\ListPlaywrights;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Seasons\Pages\EditSeason;
use App\Filament\Resources\Seasons\Pages\ListSeasons;
use App\Filament\Resources\Seasons\RelationManagers\ShowsRelationManager;
use App\Filament\Resources\ShowCasts\Pages\ManageShowCasts;
use App\Filament\Resources\ShowCrews\Pages\ManageShowCrews;
use App\Filament\Resources\Shows\Pages\EditShow;
use App\Filament\Resources\Shows\Pages\ListShows;
use App\Filament\Resources\Shows\RelationManagers\CastRelationManager;
use App\Filament\Resources\Shows\RelationManagers\CrewRelationManager;
use App\Filament\Resources\Shows\RelationManagers\PerformancesRelationManager;
use App\Filament\Resources\Tickets\Pages\EditTicket;
use App\Filament\Resources\Tickets\Pages\ListTickets;
use App\Filament\Resources\TrainingCategories\Pages\EditTrainingCategory;
use App\Filament\Resources\TrainingCategories\Pages\ListTrainingCategories;
use App\Filament\Resources\TrainingCategories\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\TrainingItems\Pages\EditTrainingItem;
use App\Filament\Resources\TrainingItems\Pages\ListTrainingItems;
use App\Filament\Resources\TrainingItems\RelationManagers\SessionsRelationManager;
use App\Filament\Resources\TrainingSessionPeople\Pages\ManageTrainingSessionPeople;
use App\Filament\Resources\TrainingSessions\Pages\EditTrainingSession;
use App\Filament\Resources\TrainingSessions\Pages\ListTrainingSessions;
use App\Filament\Resources\TrainingSessions\RelationManagers\PeopleRelationManager;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Filament\Resources\Venues\Pages\EditVenue;
use App\Filament\Resources\Venues\Pages\ListVenues;
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
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;

test('a show performance requires a positive capacity', function () {
    $this->actingAs(User::factory()->create());
    $show = Show::factory()->create();
    $venue = Venue::factory()->create();

    Livewire::test(PerformancesRelationManager::class, [
        'ownerRecord' => $show,
        'pageClass' => EditShow::class,
    ])->callAction(TestAction::make('create')->table(), [
        'venue_id' => $venue->id,
        'capacity' => 0,
    ])->assertHasActionErrors(['capacity']);

    $this->assertDatabaseMissing('performances', ['show_id' => $show->id, 'capacity' => 0]);
});

test('the :dataset resource lists and opens records for editing', function (string $model, string $listPage, string $editPage) {
    $this->actingAs(User::factory()->create());
    $record = $model::factory()->create();

    Livewire::test($listPage)->assertCanSeeTableRecords([$record]);
    Livewire::test($editPage, ['record' => $record->getKey()])->assertOk()->assertFormExists();
})->with([
    'People' => [Person::class, ListPeople::class, EditPerson::class],
    'Performances' => [Performance::class, ListPerformances::class, EditPerformance::class],
    'Playwrights' => [Playwright::class, ListPlaywrights::class, EditPlaywright::class],
    'Roles' => [Role::class, ListRoles::class, EditRole::class],
    'Seasons' => [Season::class, ListSeasons::class, EditSeason::class],
    'Shows' => [Show::class, ListShows::class, EditShow::class],
    'Tickets' => [Ticket::class, ListTickets::class, EditTicket::class],
    'TrainingCategories' => [TrainingCategory::class, ListTrainingCategories::class, EditTrainingCategory::class],
    'TrainingItems' => [TrainingItem::class, ListTrainingItems::class, EditTrainingItem::class],
    'TrainingSessions' => [TrainingSession::class, ListTrainingSessions::class, EditTrainingSession::class],
    'Venues' => [Venue::class, ListVenues::class, EditVenue::class],
]);

test('the :dataset resource lists records', function (string $model, string $page) {
    $this->actingAs(User::factory()->create());
    $record = $model::factory()->create();

    Livewire::test($page)->assertCanSeeTableRecords([$record]);
})->with([
    'ShowCasts' => [ShowCast::class, ManageShowCasts::class],
    'ShowCrews' => [ShowCrew::class, ManageShowCrews::class],
    'TrainingSessionPeople' => [TrainingSessionPerson::class, ManageTrainingSessionPeople::class],
    'Users' => [User::class, ManageUsers::class],
]);

test('the :dataset relation manager lists related records', function (string $ownerModel, string $relatedModel, string $foreignKey, string $manager, string $page) {
    $this->actingAs(User::factory()->create());
    $owner = $ownerModel::factory()->create();
    $related = $relatedModel::factory()->create([$foreignKey => $owner->getKey()]);

    Livewire::test($manager, ['ownerRecord' => $owner, 'pageClass' => $page])
        ->assertCanSeeTableRecords([$related]);
})->with([
    'Shows Cast' => [Show::class, ShowCast::class, 'show_id', CastRelationManager::class, EditShow::class],
    'Shows Crew' => [Show::class, ShowCrew::class, 'show_id', CrewRelationManager::class, EditShow::class],
    'Shows Performances' => [Show::class, Performance::class, 'show_id', PerformancesRelationManager::class, EditShow::class],
    'People Cast' => [Person::class, ShowCast::class, 'person_id', App\Filament\Resources\People\RelationManagers\CastRelationManager::class, EditPerson::class],
    'People Crew' => [Person::class, ShowCrew::class, 'person_id', App\Filament\Resources\People\RelationManagers\CrewRelationManager::class, EditPerson::class],
    'People TrainingSessionPeople' => [Person::class, TrainingSessionPerson::class, 'person_id', TrainingSessionPeopleRelationManager::class, EditPerson::class],
    'Performances Tickets' => [Performance::class, Ticket::class, 'performance_id', TicketsRelationManager::class, EditPerformance::class],
    'TrainingCategories Items' => [TrainingCategory::class, TrainingItem::class, 'training_category_id', ItemsRelationManager::class, EditTrainingCategory::class],
    'TrainingItems Sessions' => [TrainingItem::class, TrainingSession::class, 'training_item_id', SessionsRelationManager::class, EditTrainingItem::class],
    'TrainingSessions People' => [TrainingSession::class, TrainingSessionPerson::class, 'training_session_id', PeopleRelationManager::class, EditTrainingSession::class],
    'Seasons Shows' => [Season::class, Show::class, 'season_id', ShowsRelationManager::class, EditSeason::class],
    'Playwrights Shows' => [Playwright::class, Show::class, 'playwright_id', App\Filament\Resources\Playwrights\RelationManagers\ShowsRelationManager::class, EditPlaywright::class],
    'Venues Performances' => [Venue::class, Performance::class, 'venue_id', App\Filament\Resources\Venues\RelationManagers\PerformancesRelationManager::class, EditVenue::class],
    'Roles Crew' => [Role::class, ShowCrew::class, 'role_id', App\Filament\Resources\Roles\RelationManagers\CrewRelationManager::class, EditRole::class],
]);

test('a venue performance requires a positive capacity', function () {
    $this->actingAs(User::factory()->create());
    $show = Show::factory()->create();
    $venue = Venue::factory()->create();

    Livewire::test(App\Filament\Resources\Venues\RelationManagers\PerformancesRelationManager::class, [
        'ownerRecord' => $venue,
        'pageClass' => EditVenue::class,
    ])->callAction(TestAction::make('create')->table(), [
        'show_id' => $show->id,
        'capacity' => 0,
    ])->assertHasActionErrors(['capacity']);

    $this->assertDatabaseMissing('performances', ['show_id' => $show->id, 'venue_id' => $venue->id, 'capacity' => 0]);
});
