<?php

declare(strict_types=1);

namespace App\Application\CastMember\CreateCastMember;

use App\Domain\CastMember\CastMemberEntity;
use App\Domain\CastMember\CastMemberRepositoryInterface;
use App\Domain\CastMember\ValueObject\CastMemberId;

final readonly class CommandHandler
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): CastMemberId
    {
        $id = $this->repository->getNextId();
        $entity = new CastMemberEntity(
            $id,
            $command->role,
            $command->person->id,
            $command->showId
        );

        $this->repository->save($entity);

        return $id;
    }
}
