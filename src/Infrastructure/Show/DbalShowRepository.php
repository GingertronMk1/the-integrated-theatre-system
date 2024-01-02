<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;
use App\Domain\Show\ValueObject\ShowId;
use Doctrine\DBAL\Connection;

final readonly class DbalShowRepository implements ShowRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private ClockInterface $clock
    ) {
    }

    public function getNextId(): ShowId
    {
        return ShowId::generate();
    }

    public function createShow(ShowEntity $entity): void
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('shows')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'description' => ':description',
                'year' => ':year',
                'semester' => ':semester',
                'season' => ':season',
                'created_at' => ':now',
                'updated_at' => ':now',
            ])
            ->setParameters([
                'id' => (string) $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'year' => $entity->year,
                'semester' => $entity->semester,
                'season' => $entity->season,
                'now' => (string) $this->clock->getCurrentTime(),
            ])
            ->executeStatement();
    }

    public function updateShow(ShowEntity $entity): void
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->update('shows')
            ->set('name', ':name')
            ->set('description', ':description')
            ->set('year', ':year')
            ->set('semester', ':semester')
            ->set('season', ':season')
            ->set('updated_at', ':now')
            ->setParameters([
                'id' => (string) $entity->id,
                'name' => $entity->name,
                'description' => $entity->description,
                'year' => $entity->year,
                'semester' => $entity->semester,
                'season' => $entity->season,
                'now' => (string) $this->clock->getCurrentTime(),
            ])
            ->where('id = :id')
            ->executeStatement();
    }
}
