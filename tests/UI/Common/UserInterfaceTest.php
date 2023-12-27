<?php

declare(strict_types=1);

namespace Tests\UI\Common;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class UserInterfaceTest extends WebTestCase
{
    protected readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        self::bootKernel();
    }
}
