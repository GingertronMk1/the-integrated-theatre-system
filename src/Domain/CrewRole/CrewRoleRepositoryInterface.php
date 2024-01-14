<?php

declare(strict_types=1);

namespace App\Domain\CrewRole;

use App\Domain\CrewRole\ValueObject\CrewRoleId;

interface CrewRoleRepositoryInterface
{
    public function getNextId(): CrewRoleId;

    public function save(CrewRoleEntity $entity): void;
}
