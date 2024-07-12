<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Request;

use App\Http\Requests\UpdatePersonRequest;
use Tests\TestCase;

class UpdatePersonRequestTest extends TestCase
{
    public function testAuthorize(): void
    {
        $request = new UpdatePersonRequest();
        $this->assertTrue($request->authorize());
    }

    public function testRules(): void
    {
        $request = new UpdatePersonRequest();
        $this->assertEquals([], $request->rules());
    }
}
