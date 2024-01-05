<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewMember;

use App\Application\CrewMember\CrewMemberFinderInterface;
use App\Application\CrewMember\CrewMemberModel;
use App\Application\CrewRole\CrewRoleFinderInterface;
use App\Application\Person\PersonFinderInterface;
use App\Domain\CrewMember\CrewMemberException;
use App\Domain\CrewMember\ValueObject\CrewMemberId;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\Show\ValueObject\ShowId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalCrewMemberFinder extends AbstractDbalFinder implements CrewMemberFinderInterface
{
    public function __construct(
        private Connection $connection,
        private readonly CrewRoleFinderInterface $crewRoleFinder,
        private readonly PersonFinderInterface $personFinder
    ) {
    }

    public function find(CrewMemberId $id): CrewMemberModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw new CrewMemberException("No CrewMember found with ID {$id}");
        }

        return $this->createFromRow($row);
    }

    public function findAll(): array
    {
        return [];
    }

    /**
     * @param array<string, ?string> $row
     */
    private function createFromRow(array $row): CrewMemberModel
    {
        return new CrewMemberModel(
            CrewMemberId::fromString($row['id']),
            $this->personFinder->findById(PersonId::fromString($row['person_id'])),
            $this->crewRoleFinder->find(CrewRoleId::fromString($row['role_id'])),
            $row['notes']
        );
    }

    protected function getTable(): string
    {
        return 'crew_members';
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
}
