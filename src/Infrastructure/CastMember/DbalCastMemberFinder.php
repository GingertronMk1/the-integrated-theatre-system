<?php

declare(strict_types=1);

namespace App\Infrastructure\CastMember;

use App\Application\CastMember\CastMemberFinderInterface;
use App\Domain\CastMember\CastMemberException;
use App\Domain\CastMember\ValueObject\CastMemberId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalCastMemberFinder extends AbstractDbalFinder implements CastMemberFinderInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    protected function getTable(): string
    {
        return 'CHANGEME';
    }

    public function find(CastMemberId $id): CastMemberModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw new CastMemberException("No CastMember found with ID {$id}");
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
    private function createFromRow(array $row): CastMemberModel
    {
        return new CastMemberModel(
            CastMemberId::fromString($row['id'])
        );
    }
}
