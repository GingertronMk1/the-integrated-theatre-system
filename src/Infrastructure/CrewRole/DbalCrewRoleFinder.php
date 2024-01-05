<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewRole;

use App\Application\CrewRole\CrewRoleFinderInterface;
use App\Domain\CrewRole\CrewRoleException;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;
use App\Application\CrewRole\CrewRoleModel;

final class DbalCrewRoleFinder extends AbstractDbalFinder implements CrewRoleFinderInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    protected function getTable(): string
    {
        return 'CHANGEME';
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

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from($this->getTable())
            ->fetchAllAssociative();

        return array_map(
            fn (array $row) => $this->createFromRow($row),
            $rows
        );
    }

    /**
     * @param array<string, ?string> $row
     */
    private function createFromRow(array $row): CrewRoleModel
    {
        return new CrewRoleModel(
            CrewRoleId::fromString($row['id'])
        );
    }
}
