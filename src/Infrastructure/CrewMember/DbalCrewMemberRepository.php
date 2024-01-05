<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewMember;

use App\Application\Common\Service\ClockInterface;
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
        private readonly ClockInterface $clock
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
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } elseif (1 === $count) {
            $upsertQb
                ->update($this->getTable())
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        } else {
            throw new CrewMemberException("Too many rows with ID {$entity->id}");
        }

        $upsertQb
            ->setParameters([
                'id' => (string) $entity->id,
                'now' => (string) $this->clock->getCurrentTime(),
            ]);
    }

    protected function getTable(): string
    {
        return 'CHANGE_ME';
    }
}
