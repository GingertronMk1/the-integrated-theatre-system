<?php

declare(strict_types=1);

namespace App\Infrastructure\CastMember;

use App\Application\Common\Service\ClockInterface;
use App\Domain\CastMember\CastMemberEntity;
use App\Domain\CastMember\CastMemberException;
use App\Domain\CastMember\CastMemberRepositoryInterface;
use App\Domain\CastMember\ValueObject\CastMemberId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalCastMemberRepository extends AbstractDbalRepository implements CastMemberRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): CastMemberId
    {
        return CastMemberId::generate();
    }

    public function save(CastMemberEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);

        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'person_id' => ':person_id',
                    'show_id' => ':show_id',
                    'role' => ':role',
                ]);
        } elseif (1 === $count) {
            $upsertQb
                ->update($this->getTable())
                ->set('person_id', ':person_id')
                ->set('show_id', ':show_id')
                ->set('role', ':role')
                ->where('id = :id')
            ;
        } else {
            throw new CastMemberException("Too many rows with ID {$entity->id}");
        }

        $upsertQb
            ->setParameters([
                'id' => (string) $entity->id,
                'person_id' => (string) $entity->personId,
                'show_id' => (string) $entity->showId,
                'role' => $entity->role,
            ])
            ->executeStatement();
    }

    protected function getTable(): string
    {
        return 'cast_members';
    }
}
