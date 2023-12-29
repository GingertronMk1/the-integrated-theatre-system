<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Application\Person\PersonFinderInterface;
use App\Application\Person\PersonModel;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\User\ValueObject\UserId;
use Doctrine\DBAL\Connection;

class DbalPersonFinder implements PersonFinderInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function findById(PersonId $id): PersonModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('people', 'p')
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->executeQuery()
            ->fetchAssociative()
        ;

        return $this->createPersonFromRow($row);
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from('people', 'p')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return array_map(
            fn (array $row) => $this->createPersonFromRow($row),
            $rows
        );
    }

    private function createPersonFromRow(array $row): PersonModel
    {
        $userId = !is_null($row['user_id']) ? UserId::fromString($row['user_id']) : null;

        return new PersonModel(
            PersonId::fromString($row['id']),
            $row['name'],
            $row['bio'],
            (int) $row['start_year'],
            (int) $row['end_year'],
            $userId
        );
    }
}
