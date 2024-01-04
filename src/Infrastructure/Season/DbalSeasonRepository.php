<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;
use App\Domain\Season\ValueObject\SeasonId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalSeasonRepository extends AbstractDbalRepository implements SeasonRepositoryInterface
{
    protected function getTable(): string
    {
        return 'seasons';
    }

    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): SeasonId
    {
        return SeasonId::generate();
    }

    public function save(SeasonEntity $entity): void
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
                    'colour' => ':colour',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } else {
            $qb
                ->insert($this->getTable())
                ->set('name', ':name')
                ->set('description', ':description')
                ->set('colour', ':colour')
                ->set('created_at', ':now')
                ->set('updated_at', ':now')
                ->where('id = :id');
        }
        $qb->setParameters([
            'id' => (string) $entity->id,
            'name' => $entity->name,
            'description' => $entity->description,
            'colour' => $entity->colour,
            'now' => (string) $this->clock->getCurrentTime(),
        ])
        ->executeStatement();
    }
}
