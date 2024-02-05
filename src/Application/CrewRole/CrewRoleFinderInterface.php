<?php

declare(strict_types=1);

namespace App\Application\CrewRole;

use App\Domain\CrewRole\ValueObject\CrewRoleId;

interface CrewRoleFinderInterface
{
    /**
     * @return array<CrewRoleModel>
     */
    public function findAll(?int $offset = null, ?int $limit = null): array;

    public function find(CrewRoleId $id): CrewRoleModel;

    public function count(?CrewRoleId $id = null): int;
}
