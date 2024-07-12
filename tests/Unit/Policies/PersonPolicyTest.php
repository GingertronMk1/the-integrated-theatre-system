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

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->person));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->person));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->person));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->person));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->person));
    }
}
