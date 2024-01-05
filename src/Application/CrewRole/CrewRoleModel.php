<?php

declare(strict_types=1);

namespace App\Application\CrewRole;

use App\Domain\CrewRole\ValueObject\CrewRoleId;

final readonly class CrewRoleModel
{
    public function __construct(
        public CrewRoleId $id,
    ) {
    }
}
