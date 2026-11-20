<?php

use App\Models\Role;
use Database\Seeders\RoleSeeder;

test('seeds the role catalogue with icons and ordering', function () {
    $this->seed(RoleSeeder::class);

    expect(Role::query()->count())->toBe(29);
    $director = Role::query()->where('name', 'Director')->firstOrFail();
    expect($director->icon)->toBe('ion-film-marker')
        ->and($director->sort)->toBe(0);
    $this->assertDatabaseHas('roles', ['name' => 'Playwright', 'sort' => 30]);
    $this->assertDatabaseHas('roles', ['name' => 'Choreographer', 'sort' => 280]);
    $this->assertDatabaseMissing('roles', ['name' => 'Assistant Director']);
});

test('seeding again updates existing roles without creating duplicates', function () {
    $role = Role::factory()->create(['name' => 'Director', 'sort' => 99, 'icon' => 'old']);

    $this->seed(RoleSeeder::class);
    $this->seed(RoleSeeder::class);

    expect(Role::query()->count())->toBe(29)
        ->and($role->fresh()->sort)->toBe(0)
        ->and($role->fresh()->icon)->toBe('ion-film-marker');
});
