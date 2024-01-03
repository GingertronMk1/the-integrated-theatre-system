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
    private const TABLE = 'seasons';

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
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert(self::TABLE)
            ->values([
                'id' => ':id',
                'name' => ':name',
                'description' => ':description',
                'colour' => ':colour',
                'created_at' => ':now',
                'updated_at' => ':now',
            ])
            ->setParameters([
                'id' => (string) $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'colour' => $entity->colour,
                'now' => (string) $this->clock->getCurrentTime(),
            ])
            ->executeStatement();
    }

    public function updateSeason(SeasonEntity $entity): void
    {
    }
}
