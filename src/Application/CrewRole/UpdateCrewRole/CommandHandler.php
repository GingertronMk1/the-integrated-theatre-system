<?php

declare(strict_types=1);

namespace App\Application\CrewRole\UpdateCrewRole;

use App\Domain\CrewRole\CrewRoleRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private CrewRoleRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
    }
}
