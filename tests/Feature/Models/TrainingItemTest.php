<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

class TrainingItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}
