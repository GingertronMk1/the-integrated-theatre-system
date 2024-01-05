<?php

declare(strict_types=1);

namespace App\Application\CrewRole\CreateCrewRole;

use App\Domain\CrewRole\CrewRoleEntity;
use App\Domain\CrewRole\CrewRoleRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private CrewRoleRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $entity = new CrewRoleEntity(
            $this->repository->getNextId(),
            $command->name,
            $command->description,
        );

        $this->repository->save($entity);
    }
}
