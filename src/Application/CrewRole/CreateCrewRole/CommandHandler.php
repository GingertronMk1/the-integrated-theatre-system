<?php

declare(strict_types=1);

namespace App\Application\CrewRole\CreateCrewRole;

use App\Domain\CrewRole\CrewRoleEntity;
use App\Domain\CrewRole\CrewRoleRepositoryInterface;
use App\Domain\CrewRole\ValueObject\CrewRoleId;

final readonly class CommandHandler
{
    public function __construct(
        private CrewRoleRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): CrewRoleId
    {
        $id = $this->repository->getNextId();
        $entity = new CrewRoleEntity(
            $id,
            $command->name,
            $command->description,
        );

        $this->repository->save($entity);

        return $id;
    }
}
