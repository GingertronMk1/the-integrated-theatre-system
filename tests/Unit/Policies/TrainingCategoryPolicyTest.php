<?php

declare(strict_types=1);

namespace Tests\Unit\Policies;

use App\Models\TrainingCategory;
use App\Policies\TrainingCategoryPolicy;
use Tests\TestCase;

class TrainingCategoryPolicyTest extends TestCase
{
    private TrainingCategoryPolicy $policy;

    private TrainingCategory $trainingcategory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new TrainingCategoryPolicy();
        $this->trainingcategory = TrainingCategory::factory()->make();
    }

    public function testViewAny(): void
    {
        $this->assertTrue($this->policy->viewAny($this->user));
    }

    public function testView(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->trainingcategory));
    }

    public function testCreate(): void
    {
        $this->assertTrue($this->policy->create($this->user));
    }

    public function testUpdate(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->trainingcategory));
    }

    public function testDelete(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->trainingcategory));
    }

    public function testRestore(): void
    {
        $this->assertTrue($this->policy->restore($this->user, $this->trainingcategory));
    }

    public function testForceDelete(): void
    {
        $this->assertTrue($this->policy->forceDelete($this->user, $this->trainingcategory));
    }
}
