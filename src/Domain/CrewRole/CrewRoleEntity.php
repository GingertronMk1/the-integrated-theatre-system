<?php

declare(strict_types=1);

namespace App\Domain\CrewRole;

use App\Domain\CrewRole\ValueObject\CrewRoleId;

final class CrewRoleEntity
{
    public function __construct(
        public CrewRoleId $id,
        public string $name,
        public string $description
    ) {
    }
}
