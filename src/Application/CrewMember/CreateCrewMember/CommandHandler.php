<?php

declare(strict_types=1);

namespace App\Application\CrewMember\CreateCrewMember;

use App\Domain\CrewMember\CrewMemberEntity;
use App\Domain\CrewMember\CrewMemberRepositoryInterface;
use App\Domain\CrewMember\ValueObject\CrewMemberId;

final readonly class CommandHandler
{
    public function __construct(
        private CrewMemberRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): CrewMemberId
    {
        $id = $this->repository->getNextId();
        $crewMember = new CrewMemberEntity(
            $id,
            $command->person->id,
            $command->crewRole->id,
            $command->notes,
            $command->showId
        );
        $this->repository->save($crewMember);

        return $id;
    }
}
