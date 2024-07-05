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

    public function test_view_any(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_view(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->show));
    }

    public function test_create(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_update(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->show));
    }

    public function test_delete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->show));
    }

    public function test_restore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->show));
    }

    public function test_force_delete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->show));
    }
}
