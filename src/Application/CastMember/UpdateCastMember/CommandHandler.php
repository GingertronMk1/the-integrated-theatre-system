<?php

declare(strict_types=1);

namespace App\Application\CastMember\UpdateCastMember;

use App\Domain\CastMember\CastMemberEntity;
use App\Domain\CastMember\CastMemberRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private CastMemberRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $entity = new CastMemberEntity(
            $command->id
        );

        $this->repository->save($entity);
    }
}
