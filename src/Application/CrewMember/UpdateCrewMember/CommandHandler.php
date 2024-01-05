<?php

declare(strict_types=1);

namespace App\Application\CrewMember\UpdateCrewMember;

use App\Domain\CrewMember\CrewMemberRepositoryInterface;
use App\Domain\CrewMember\CrewMemberEntity;

final readonly class CommandHandler
{
    public function __construct(
        private CrewMemberRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $crewMember = new CrewMemberEntity(
            $command->id
        );
        $this->repository->save($entity)
    }
}
