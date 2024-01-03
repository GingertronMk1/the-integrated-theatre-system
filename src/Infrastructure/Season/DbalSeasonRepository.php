<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;
use App\Domain\Season\ValueObject\SeasonId;
use Doctrine\DBAL\Connection;

final readonly class DbalSeasonRepository implements SeasonRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private ClockInterface $clock
    ) {
    }

    public function getNextId(): SeasonId
    {
        return SeasonId::generate();
    }

    public function createSeason(SeasonEntity $entity): void
    {

    }

    public function updateSeason(SeasonEntity $entity): void
    {

    }
}
