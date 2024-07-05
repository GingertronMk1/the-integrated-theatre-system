<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\TrainingSession;
use App\Policies\TrainingSessionPolicy;
use Tests\TestCase;

class TrainingSessionPolicyTest extends TestCase
{
    private TrainingSessionPolicy $policy;

    private TrainingSession $trainingsession;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new TrainingSessionPolicy();
        $this->trainingsession = TrainingSession::factory()->make();
    }

    public function test_view_any(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function test_view(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->trainingsession));
    }

    public function test_create(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function test_update(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->trainingsession));
    }

    public function test_delete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->trainingsession));
    }

    public function test_restore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->trainingsession));
    }

    public function test_force_delete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->trainingsession));
    }
}
