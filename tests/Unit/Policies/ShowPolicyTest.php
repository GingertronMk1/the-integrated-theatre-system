<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\Show;
use App\Policies\ShowPolicy;
use Tests\TestCase;

class ShowPolicyTest extends TestCase
{
    private ShowPolicy $policy;

    private Show $show;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new ShowPolicy();
        $this->show = Show::factory()->make();
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->show));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->show));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->show));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->show));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->show));
    }
}
