<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Season;
use App\Policies\SeasonPolicy;
use Tests\TestCase;

class SeasonPolicyTest extends TestCase
{
    private SeasonPolicy $policy;

    private Season $season;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new SeasonPolicy();
        $this->season = Season::factory()->make();
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->season));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->season));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->season));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->season));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->season));
    }
}
