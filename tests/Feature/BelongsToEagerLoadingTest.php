<?php

use App\Models\Performance;
use App\Models\Person;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use App\Models\Ticket;
use App\Models\TrainingItem;
use App\Models\TrainingSession;
use App\Models\TrainingSessionPerson;
use App\Models\User;

test(':dataset belongs-to relationships are loaded with their records by default', function (string $model, array $relationships) {
    $created = $model::factory()->count(2)->create();
    $records = $model::query()->whereKey($created->modelKeys())->get();

    foreach ($records as $record) {
        foreach ($relationships as $relationship) {
            expect($record->relationLoaded($relationship))->toBeTrue();
            $related = $record->getRelation($relationship);
            $foreignKey = $record->{$relationship}()->getForeignKeyName();
            expect($related?->getKey())->toBe($record->getAttribute($foreignKey));
        }
    }
})->with([
    'person' => [Person::class, ['user']],
    'show' => [Show::class, ['playwright', 'season']],
    'cast' => [ShowCast::class, ['show', 'person']],
    'crew' => [ShowCrew::class, ['show', 'person', 'role']],
    'performance' => [Performance::class, ['show', 'venue']],
    'ticket' => [Ticket::class, ['performance']],
    'training item' => [TrainingItem::class, ['trainingCategory']],
    'training session' => [TrainingSession::class, ['trainingItem']],
    'training participant' => [TrainingSessionPerson::class, ['trainingSession', 'person']],
]);

test('a linked user is loaded with a person', function () {
    $user = User::factory()->create();
    $person = Person::factory()->for($user)->create();

    $person = Person::query()->findOrFail($person->id);

    expect($person->relationLoaded('user'))->toBeTrue()
        ->and($person->user->is($user))->toBeTrue();
});
