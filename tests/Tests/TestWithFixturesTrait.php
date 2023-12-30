<?php

declare(strict_types=1);

namespace Tests\Tests;

trait TestWithFixturesTrait
{
    protected function loadFixtures(array $fixtures)
    {
        $container = self::getContainer();

        /* @var FixtureLoaderInterface $fixtureLoader */
        // $fixtureLoader = self::getContainer()->get(FixtureLoaderInterface::class);
        // $fixtureLoader->loadFixtures($fixtures);
    }
}
