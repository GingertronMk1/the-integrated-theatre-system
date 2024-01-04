<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\ValueObject\PersonId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalPersonRepository extends AbstractDbalRepository implements PersonRepositoryInterface
{
    protected function getTable(): string
    {
        return 'people';
    }

    public function __construct(
        private Connection $connection,
        private ClockInterface $clock
    ) {
    }

    public function getNextId(): PersonId
    {
        return PersonId::generate();
    }

    public function save(PersonEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);

        $now = (string) $this->clock->getCurrentTime();

        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'bio' => ':bio',
                    'start_year' => ':start_year',
                    'end_year' => ':end_year',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ])
            ;
        } elseif (1 === $count) {
            $upsertQb
                ->update($this->getTable())
                ->set('name', ':name')
                ->set('bio', ':bio')
                ->set('start_year', ':start_year')
                ->set('end_year', ':end_year')
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        }
        $upsertQb
            ->setParameters([
                    'id' => $entity->id,
                    'name' => $entity->name,
                    'bio' => $entity->bio,
                    'start_year' => $entity->startYear,
                    'end_year' => $entity->endYear,
                    'now' => $now,
            ])
            ->executeStatement();
    }
}
