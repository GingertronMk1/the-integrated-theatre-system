<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewRole;

use App\Application\CrewRole\CrewRoleFinderInterface;
use App\Application\CrewRole\CrewRoleModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\CrewRole\CrewRoleException;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalCrewRoleFinder extends AbstractDbalFinder implements CrewRoleFinderInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    protected function getTable(): string
    {
        return 'crew_roles';
    }

    public function find(CrewRoleId $id): CrewRoleModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw new CrewRoleException("No CrewRole found with ID {$id}");
        }

        return $this->createFromRow($row);
    }

    public function findAll(int $offset = null, int $limit = null): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    /**
     * @param array<string, ?string> $row
     */
    protected function createFromRow(array $row): CrewRoleModel
    {
        $deletedAt = null;
        if (!is_null($row['deleted_at'])) {
            $deletedAt = DateTime::fromString($row['deleted_at']);
        }

        return new CrewRoleModel(
            CrewRoleId::fromString($row['id']),
            $row['name'],
            $row['description'],
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
            $deletedAt
        );
    }

    public function count(CrewRoleId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
