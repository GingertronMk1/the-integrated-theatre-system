<?php

declare(strict_types=1);

namespace App\Application\CrewRole;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\CrewRole\ValueObject\CrewRoleId;

final readonly class CrewRoleModel
{
    public function __construct(
        public CrewRoleId $id,
        public string $name,
        public string $description,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt,
    ) {
    }
}
