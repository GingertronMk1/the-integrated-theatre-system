<?php

declare(strict_types=1);

namespace Tests\UI\Common;

use App\Application\Fixtures\FixtureLoaderInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class UserInterfaceTest extends WebTestCase
{
    protected readonly KernelBrowser $client;
    private static bool $fixturesLoaded = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->client->followRedirects();
    }

    protected function loadFixtures(string ...$fixtures)
    {
        if (self::$fixturesLoaded) {
            return;
        }
        $container = self::getContainer();

        /** @var FixtureLoaderInterface $fixtureLoader */
        $fixtureLoader = $container->get(FixtureLoaderInterface::class);
        $fixtureLoader->loadFixtures(...$fixtures);
        self::$fixturesLoaded = true;
    }
}
