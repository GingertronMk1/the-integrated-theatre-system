<?php

declare(strict_types=1);

namespace Tests\Tests;

use App\Application\Fixtures\FixtureLoaderInterface;

trait TestWithFixturesTrait
{
    protected function loadFixtures(string ...$fixtures)
    {
        $container = self::getContainer();

        /* @var FixtureLoaderInterface $fixtureLoader */
        $fixtureLoader = self::getContainer()->get(FixtureLoaderInterface::class);
        $fixtureLoader->loadFixtures(...$fixtures);
    }
}
