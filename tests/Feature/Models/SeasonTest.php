<?php

namespace Tests\Feature\Models;

use Tests\TestCase;

class SeasonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testExample(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }
}