<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Performance;
use App\Models\Show;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    public function test_show_is_accurate(): void
    {
        $show = Show::factory()->create();
        $performance = Performance::factory()->state([
            'show_id' => $show->id
        ])->create();

        $performance->refresh();
        $show->refresh();

        $this->assertContains($performance->id, $show->performances->pluck('id'));
        $this->assertEquals($show->id, $performance->show->id);
    }
}
