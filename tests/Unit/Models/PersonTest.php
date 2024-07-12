<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Person;
use App\Models\User;
use Tests\TestCase;

class PersonTest extends TestCase
{
    public function testUserIsAccurate(): void
    {
        $user = User::factory()->create();
        $person = Person::factory()->create();

        $person->user()->associate($user);
        $person->save();

        $person->refresh();
        $user->refresh();

        $this->assertEquals($person->id, $user->person->id);
        $this->assertEquals($user->id, $person->user->id);
    }
}
