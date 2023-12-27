<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

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
                throw new Exception();
            }

            $fixtureClassName = get_class($fixture);

            if (!$fixture instanceof FixtureInterface) {
                throw new Exception("{$fixtureClassName} not an instance of FixtureInterface");
            }

            $this->fixtures[$fixtureClassName] = $fixture;
        }
    }

    public function loadFixtures(string ...$fixtures): void
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

        if ($fixture instanceof DependantFixtureInterface) {
            foreach ($fixture->getDependencies() as $dependency) {
                $this->loadFixture($dependency);
            }
        }

        $fixture->load();
        $this->loadedFixtures[] = $class;
    }

    private function findFixture(string $class): FixtureInterface
    {
        if (!array_key_exists($class, $this->fixtures)) {
            throw new Exception("{$class} does not exist in fixture list ".implode(', ', array_map('get_class', $this->fixtures)));
        }

        return $this->fixtures[$class];
    }
}
