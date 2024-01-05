<?php

declare(strict_types=1);

namespace App\Infrastructure\CrewRole;

use App\Application\Common\Service\ClockInterface;
use App\Domain\CrewRole\CrewRoleEntity;
use App\Domain\CrewRole\CrewRoleException;
use App\Domain\CrewRole\CrewRoleRepositoryInterface;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalCrewRoleRepository extends AbstractDbalRepository implements CrewRoleRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): CrewRoleId
    {
        return CrewRoleId::generate();
    }

    public function save(CrewRoleEntity $entity): void
    {
        $count = $this->getCount($this->connection, $entity->id);

        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert($this->getTable())
                ->values([
                    'id' => ':id',
                    'name' => ':name',
                    'description' => ':description',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ]);
        } elseif (1 === $count) {
            $upsertQb
                ->update($this->getTable())
                ->set('name', ':name')
                ->set('description', ':description')
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        } else {
            throw new CrewRoleException("Too many rows with ID {$entity->id}");
        }

        $upsertQb
            ->setParameters([
                'id' => (string) $entity->id,
                'name' => (string) $entity->name,
                'description' => (string) $entity->description,
                'now' => (string) $this->clock->getCurrentTime(),
            ])
            ->executeStatement();
    }

    protected function getTable(): string
    {
        return 'crew_roles';
    }
}
