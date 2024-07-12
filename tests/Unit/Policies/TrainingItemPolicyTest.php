<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\TrainingItem;
use App\Policies\TrainingItemPolicy;
use Tests\TestCase;

class TrainingItemPolicyTest extends TestCase
{
    private TrainingItemPolicy $policy;

    private TrainingItem $trainingitem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new TrainingItemPolicy();
        $this->trainingitem = TrainingItem::factory()->make();
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->trainingitem));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->trainingitem));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->trainingitem));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->trainingitem));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->trainingitem));
    }
}
