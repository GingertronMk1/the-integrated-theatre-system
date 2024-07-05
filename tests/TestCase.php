<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function afterRefreshingDatabase()
    {
        $this->artisan('db:seed');
        $this->user = User::factory()->create();
    }
}
