<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Request;

use App\Http\Requests\StorePersonRequest;
use Tests\TestCase;

class StorePersonRequestTest extends TestCase
{
    public function testAuthorize(): void
    {
        $request = new StorePersonRequest();
        $this->assertTrue($request->authorize());
    }

    public function testRules(): void
    {
        $request = new StorePersonRequest();
        $this->assertEquals([], $request->rules());
    }
}
