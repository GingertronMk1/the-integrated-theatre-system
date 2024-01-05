<?php

declare(strict_types=1);

namespace App\Application\CrewRole\UpdateCrewRole;

use App\Application\CrewRole\CrewRoleModel;
use App\Domain\CrewRole\ValueObject\CrewRoleId;

final class Command
{
    public function __construct(
        public CrewRoleId $id,
    ) {
    }

    public static function forCrewRole(CrewRoleModel $command): self
    {
        return new self(
            $command->id,
        );
    }
}
