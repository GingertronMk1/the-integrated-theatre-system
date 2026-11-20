<?php

use App\Models\Role;
use App\Models\Show;
use App\Models\ShowCast;
use App\Models\ShowCrew;
use App\Models\User;

test('a show orders cast by cast sort and crew by role sort', function () {
    $show = Show::factory()->create();
    $laterCast = ShowCast::factory()->for($show)->create(['sort' => 20]);
    $earlierCast = ShowCast::factory()->for($show)->create(['sort' => 5]);
    $laterRole = Role::factory()->create(['sort' => 20]);
    $earlierRole = Role::factory()->create(['sort' => 5]);
    $laterCrew = ShowCrew::factory()->for($show)->for($laterRole)->create();
    $earlierCrew = ShowCrew::factory()->for($show)->for($earlierRole)->create();

    expect($show->cast()->pluck('id')->all())->toBe([$earlierCast->id, $laterCast->id])
        ->and($show->crew()->pluck('id')->all())->toBe([$earlierCrew->id, $laterCrew->id]);

    $show->load(['cast', 'crew']);

    expect($show->cast->modelKeys())->toBe([$earlierCast->id, $laterCast->id])
        ->and($show->crew->modelKeys())->toBe([$earlierCrew->id, $laterCrew->id]);
});

test('credit sort values can be updated and must be unsigned integers', function () {
    $this->actingAs(User::factory()->create());
    $role = Role::factory()->create();
    $cast = ShowCast::factory()->create();

    $this->patchJson(route('api.v1.roles.update', $role), ['sort' => 4])->assertOk()->assertJsonPath('data.sort', 4);
    $this->patchJson(route('api.v1.show-cast.update', $cast), ['sort' => 8])->assertOk()->assertJsonPath('data.sort', 8);
    $this->patchJson(route('api.v1.roles.update', $role), ['sort' => -1])->assertUnprocessable()->assertJsonValidationErrors('sort');
    $this->patchJson(route('api.v1.show-cast.update', $cast), ['sort' => 1.5])->assertUnprocessable()->assertJsonValidationErrors('sort');
});
