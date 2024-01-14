<?php

declare(strict_types=1);

namespace App\Infrastructure\CastMember;

use App\Application\CastMember\CastMemberFinderInterface;
use App\Application\CastMember\CastMemberModel;
use App\Application\Person\PersonFinderInterface;
use App\Domain\CastMember\CastMemberException;
use App\Domain\CastMember\ValueObject\CastMemberId;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\Show\ValueObject\ShowId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalCastMemberFinder extends AbstractDbalFinder implements CastMemberFinderInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly PersonFinderInterface $personFinder
    ) {
    }

    protected function getTable(): string
    {
        return 'cast_members';
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
            CastMemberId::fromString($row['id']),
            $row['role'],
            $this->personFinder->find(PersonId::fromString($row['person_id']))
        );
    }

    public function findForShow(ShowId $id): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('show_id = :show_id')
            ->setParameter('show_id', (string) $id)
            ->orderBy('credit_order', 'asc')
            ->addOrderBy('id', 'asc')
            ->fetchAllAssociative();

        return array_map(
            fn (array $row) => $this->createFromRow($row),
            $rows
        );
    }

    public function count(CastMemberId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
