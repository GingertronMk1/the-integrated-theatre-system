<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use App\Application\Fixtures\FixtureInterface;
use App\Application\Fixtures\FixtureLoaderInterface;
use Exception;

final class FixtureLoader implements FixtureLoaderInterface
{
    /** @var FixtureInterface[] */
    private array $fixtures = [];

    /** @var string[] */
    private array $loadedFixtures = [];

    /**
     * @param FixtureInterface[] $fixtures
     */
    public function __construct(
        iterable $fixtures
    ) {
        // Build an associative map of class name to fixture.
        foreach ($fixtures as $fixture) {
            if (!is_object($fixture)) {
                // throw FixtureException::nonObjectFixturePassedToLoader();
            }

            $fixtureClassName = $fixture::class;

            if (!$fixture instanceof FixtureInterface) {
                // throw FixtureException::invalidFixturePassedToLoader($fixtureClassName);
            }

            $this->fixtures[$fixtureClassName] = $fixture;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadFixtures(array $fixtures): void
    {
        foreach ($fixtures as $class) {
            $this->loadFixture($class);
        }
    }

    private function loadFixture(string $class): void
    {
        // If we've already loaded this fixture then we can skip over it
        if (in_array($class, $this->loadedFixtures)) {
            return;
        }

        $fixture = $this->findFixture($class);

        // If this is a dependent fixture then before loading this fixture, we need to
        // load any dependencies first (and any dependencies of the dependencies etc...)
        // if ($fixture instanceof DependentFixtureInterface) {
        //     foreach ($fixture->getDependencies() as $dependency) {
        //         $this->loadFixture($dependency);
        //     }
        // }

        $fixture->load();
        $this->loadedFixtures[] = $class;
    }

    private function findFixture(string $class): FixtureInterface
    {
        if (!array_key_exists($class, $this->fixtures)) {
            // throw FixtureException::fixtureNotFoundByLoader($class);
        }

        return $this->fixtures[$class];
    }}
