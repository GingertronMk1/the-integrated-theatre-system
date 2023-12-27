<?php

declare(strict_types=1);

namespace Tests\UI\Common;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\UI\Common\Traits\TestWithFixturesTrait;

abstract class UserInterfaceTest extends WebTestCase
{
    use TestWithFixturesTrait;

    protected readonly KernelBrowser $client;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();
        $this->client = self::createClient();
        $this->client->followRedirects();
        parent::setUp();
    }

}
