<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewMember;

use App\Application\CrewMember\CrewMemberEntity;
use App\Application\CrewMember\CrewMemberFinderInterface;
use App\Domain\CrewMember\CrewMemberException;
use App\Domain\CrewMember\ValueObject\CrewMemberId;
use Doctrine\DBAL\Connection;

final readonly class DbalCrewMemberFinder implements CrewMemberFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function find(CrewMemberId $id): CrewMemberModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from(self::TABLE)
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
     * @param array<string, (int|string|null)> $row
     */
    private function createFromRow(array $row): CrewMemberEntity
    {
        return new CrewMemberEntity(
            CrewMemberId::fromString($row['id'])
        );
    }
}
