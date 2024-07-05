<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Person;
use App\Policies\PersonPolicy;
use Tests\TestCase;

class PersonPolicyTest extends TestCase
{
    private PersonPolicy $policy;

    private Person $person;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PersonPolicy();
        $this->person = Person::factory()->make();
    }

    public function test_view_any(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_view(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->person));
    }

    public function test_create(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_update(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->person));
    }

    public function test_delete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->person));
    }

    public function test_restore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->person));
    }

    public function test_force_delete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->person));
    }
}
