<?php

declare(strict_types=1);

namespace App\Application\CrewRole\UpdateCrewRole;

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
        $entity = new CrewRoleEntity(
            $command->id,
            $command->name,
            $command->description,
        );
        $this->repository->save($entity);

        return $command->id;
    }
}
