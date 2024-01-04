<?php

declare(strict_types=1);

namespace App\Application\Season;

use App\Application\Fixtures\FixtureInterface;
use App\Domain\Common\ValueObject\Colour;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;
use App\Domain\Season\ValueObject\SeasonId;

final class SeasonFixture implements FixtureInterface
{
    public function __construct(
        private readonly SeasonRepositoryInterface $repository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getAllFixtures() as $fixture) {
            $this->repository->save($fixture);
        }
    }

    /**
     * @return array<int, SeasonEntity>
     */
    private function getAllFixtures(): array
    {
        return [
            self::inHouseSeason(),
        ];
    }

    public static function inHouseSeason(): SeasonEntity
    {
        return new SeasonEntity(
            SeasonId::fromString('018cd3e0-0c27-7e9d-a0b8-8e67f62b10b1'),
            'In-House',
            'Shows with big budgets and stuff',
            Colour::fromString('#391735')
        );
    }
}
