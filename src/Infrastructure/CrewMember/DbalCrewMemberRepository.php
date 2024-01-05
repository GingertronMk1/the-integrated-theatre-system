<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewMember;

use App\Domain\CrewMember\CrewMemberEntity;
use App\Domain\CrewMember\CrewMemberException;
use App\Domain\CrewMember\CrewMemberRepositoryInterface;
use App\Domain\CrewMember\ValueObject\CrewMemberId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalCrewMemberRepository extends AbstractDbalRepository implements CrewMemberRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function getNextId(): CrewMemberId
    {
        return CrewMemberId::generate();
    }

    public function save(CrewMemberEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);

        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'role_id' => ':role_id',
                    'show_id' => ':show_id',
                    'person_id' => ':person_id',
                    'notes' => ':notes',
                ]);
        } elseif (1 === $count) {
            $upsertQb
                ->update($this->getTable())
                ->set('role_id', ':role_id')
                ->set('show_id', ':show_id')
                ->set('person_id', ':person_id')
                ->set('notes', ':notes')
                ->where('id = :id')
            ;
        } else {
            throw new CrewMemberException("Too many rows with ID {$entity->id}");
        }

        $upsertQb
            ->setParameters([
                'id' => (string) $entity->id,
                'role_id' => $entity->crewRoleId,
                'show_id' => $entity->showId,
                'person_id' => $entity->personId,
                'notes' => $entity->notes,
            ])
            ->executeStatement();
    }

    protected function getTable(): string
    {
        return 'crew_members';
    }
}
