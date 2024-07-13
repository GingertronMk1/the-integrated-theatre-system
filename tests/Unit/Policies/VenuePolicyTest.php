<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Venue;
use App\Policies\VenuePolicy;
use Tests\TestCase;

class VenuePolicyTest extends TestCase
{
    private VenuePolicy $policy;

    private Venue $venue;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new VenuePolicy();
        $this->venue = Venue::factory()->make();
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->venue));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->venue));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->venue));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->venue));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->venue));
    }
}
