<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Performance;
use App\Models\Show;
use App\Policies\PerformancePolicy;
use Tests\TestCase;

class PerformancePolicyTest extends TestCase
{
    private PerformancePolicy $policy;

    private Performance $performance;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PerformancePolicy();
        $show = Show::factory()->create();
        $this->performance = Performance::factory()
            ->for($show)
            ->make()
        ;
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->performance));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->performance));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->performance));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->performance));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->performance));
    }
}
