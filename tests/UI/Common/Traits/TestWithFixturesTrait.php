<?php

declare(strict_types=1);

namespace Tests\UI\Common\Traits;

use App\Application\Fixtures\FixtureLoaderInterface;
use App\Domain\Common\DatabaseUtilInterface;

trait TestWithFixturesTrait  
{
    protected array $fixtureClasses = [];

    public function setUp(): void
    {
        $this->loadFixtures(...$this->fixtureClasses);
        parent::setUp();
    }

    public function tearDown(): void
    {
        /** @var DatabaseUtilInterface $dbUtils */
        $dbUtils = self::getContainer()->get(DatabaseUtilInterface::class);
        $dbUtils->truncateAllTables();
        parent::tearDown();
    }

    protected function loadFixtures(string ...$fixtures)
    {
        /** @var FixtureLoaderInterface $fixtureLoader */
        $fixtureLoader = self::getContainer()->get(FixtureLoaderInterface::class);
        $fixtureLoader->loadFixtures(...$fixtures);
    }

}
