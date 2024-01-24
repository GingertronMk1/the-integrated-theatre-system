<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Application\Person\PersonFinderInterface;
use App\Application\Person\PersonModel;
use App\Application\User\UserFinderInterface;
use App\Domain\Person\PersonException;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\User\ValueObject\UserId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

class DbalPersonFinder extends AbstractDbalFinder implements PersonFinderInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly UserFinderInterface $userFinder
    ) {
    }

    protected function getTable(): string
    {
        return 'people';
    }

    public function find(PersonId $id): PersonModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->executeQuery()
            ->fetchAssociative()
        ;

        if (!is_array($row)) {
            throw PersonException::notFound($id);
        }

        return $this->createFromRow($row);
    }

    public function findAll(array $ids = [], int $offset, int $limit): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    /**
     * @param array<string, ?string> $row
     */
    protected function createFromRow(array $row): PersonModel
    {
        $user = null;
        $dbUserId = $row['user_id'];

        if (!is_null($dbUserId)) {
            $userId = UserId::fromString($dbUserId);
            $user = $this->userFinder->find($userId);
        }

        return new PersonModel(
            PersonId::fromString($row['id']),
            $row['name'],
            $row['bio'],
            (int) $row['start_year'],
            (int) $row['end_year'],
            $user
        );
    }

    public function count(PersonId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
