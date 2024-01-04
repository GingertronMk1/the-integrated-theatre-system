<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;
use App\Domain\Show\ValueObject\ShowId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalShowRepository extends AbstractDbalRepository implements ShowRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): ShowId
    {
        return ShowId::generate();
    }

    public function save(ShowEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);
        $qb = $this->connection->createQueryBuilder();

        if (0 === $count) {
            $qb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'description' => ':description',
                    'year' => ':year',
                    'semester' => ':semester',
                    'season_id' => ':season_id',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } else {
            $qb
                ->update($this->getTable())
                ->set('name', ':name')
                ->set('description', ':description')
                ->set('year', ':year')
                ->set('semester', ':semester')
                ->set('season_id', ':season_id')
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        }
        $qb->setParameters([
            'id' => (string) $entity->id,
            'name' => $entity->name,
            'description' => $entity->description,
            'year' => $entity->year,
            'semester' => $entity->semester,
            'season_id' => $entity->seasonId,
            'now' => (string) $this->clock->getCurrentTime(),
        ])
        ->executeStatement();
    }

    protected function getTable(): string
    {
        return 'shows';
    }
}
