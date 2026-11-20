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

test('models have timestamps and can be soft deleted and restored', function (string $modelClass) {
    /** @var Model $model */
    $model = $modelClass::factory()->create();

    expect($model->created_at)->not->toBeNull()
        ->and($model->updated_at)->not->toBeNull();

    $model->delete();

    $this->assertSoftDeleted($model);
    expect($modelClass::query()->find($model->getKey()))->toBeNull();

    $model->restore();

    $this->assertNotSoftDeleted($model);
    expect($modelClass::query()->find($model->getKey()))->not->toBeNull();
})->with([
    Performance::class, Person::class, Playwright::class, Role::class, Season::class,
    Show::class, ShowCast::class, ShowCrew::class, Ticket::class, TrainingCategory::class,
    TrainingItem::class, TrainingSession::class, TrainingSessionPerson::class, User::class, Venue::class,
]);
