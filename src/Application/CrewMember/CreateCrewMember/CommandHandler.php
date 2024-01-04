<?php

declare(strict_types=1);

namespace App\Application\CrewMember\CreateCrewMember;

use App\Domain\CrewMember\CrewMemberRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private CrewMemberRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
    }
}
