<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\ValueObject\PersonId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class DbalPersonRepository implements PersonRepositoryInterface
{
    public const PEOPLE_TABLE = 'people';

    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function getNextId(): PersonId
    {
        return PersonId::generate();
    }

    public function savePerson(PersonEntity $entity): void
    {
        $existsQb = $this->connection->createQueryBuilder();
        $count = $existsQb
            ->select('COUNT(*)')
            ->from(self::PEOPLE_TABLE)
            ->where('id = :id')
            ->setParameter('id', (string) $entity->id)
            ->fetchOne();

        $now = (new DateTimeImmutable())->format('c');

        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert(self::PEOPLE_TABLE)
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
                ->update(self::PEOPLE_TABLE)
                ->set('name', ':name')
                ->set('bio', ':bio')
                ->set('start_year', ':start_year')
                ->set('end_year', ':end_year')
                ->set('created_at', ':now')
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
            ->executeQuery();
    }
}
