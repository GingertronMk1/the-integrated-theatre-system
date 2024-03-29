<?php

declare(strict_types=1);

namespace Tests\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class UserInterfaceTestCase extends WebTestCase
{
    use TestWithFixturesTrait;

    protected KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = self::createClient();
        $this->client->followRedirects(true);
    }
}
