<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Application\Fixtures\FixtureInterface;
use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;
use App\Domain\Show\ValueObject\ShowId;

final readonly class ShowFixture implements FixtureInterface
{
    public function __construct(
        private ShowRepositoryInterface $showRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getFixtures() as $fixture) {
            $this->showRepository->createShow($fixture);
        }
    }

    /**
     * @return array<ShowEntity>
     */
    private function getFixtures(): array
    {
        return [
            self::testShow1(),
        ];
    }

    public static function testShow1(): ShowEntity
    {
        return new ShowEntity(
            ShowId::fromString('018ccb10-0b11-787b-8f85-29dbe0dcf765'),
            'Some Show Or Other',
            'Woooo',
            '2015-16',
            'Summer',
            null
        );
    }
}
