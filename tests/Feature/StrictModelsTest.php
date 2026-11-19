<?php

use App\Models\Show;
use App\Models\User;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\MissingAttributeException;
use Illuminate\Database\LazyLoadingViolationException;

test('models reject silently discarded attributes', function () {
    $user = User::factory()->make();

    expect(fn () => $user->fill(['unsupported_attribute' => 'value']))->toThrow(MassAssignmentException::class);
});

test('models reject access to attributes that were not selected', function () {
    User::factory()->create();
    $user = User::query()->select('id')->firstOrFail();

    expect(fn () => $user->name)->toThrow(MissingAttributeException::class);
});

test('models reject lazy loading on query collections', function () {
    Show::factory()->count(2)->create();
    $show = Show::query()->get()->first();

    expect(fn () => $show->performances)->toThrow(LazyLoadingViolationException::class);
});
