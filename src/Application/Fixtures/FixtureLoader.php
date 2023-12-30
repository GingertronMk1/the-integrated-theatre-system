<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use Exception;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

final class FixtureLoader implements FixtureLoaderInterface
{
    /** @var array<int, string> */
    private static array $loadedFixtures = [];

    /** @var array<string, FixtureInterface> */
    private array $fixtures = [];

    public function __construct(
        #[TaggedIterator('app.fixture')]
        iterable $fixtures
    ) {
        foreach ($fixtures as $fixture) {
            $fixtureClass = get_class($fixture);
            $this->fixtures[$fixtureClass] = $fixture;
        }
    }

    public function loadFixtures(string ...$fixtures): void
    {
        foreach ($fixtures as $fixture) {
            $this->loadFixture($fixture);
        }
    }

    private function loadFixture(string $fixture): void
    {
        if (in_array($fixture, self::$loadedFixtures)) {
            return;
        }

        if (!array_key_exists($fixture, $this->fixtures)) {
            throw new Exception(sprintf('Fixture %s does not exist in %s', $fixture, implode(', ', array_keys($this->fixtures))));
        }
        $fixtureModel = $this->fixtures[$fixture];

        if ($fixtureModel instanceof DependentFixtureInterface) {
            $this->loadFixtures(...$fixtureModel->getDependencies());
        }

        $fixtureModel->load();
        self::$loadedFixtures[] = $fixture;
    }
}
