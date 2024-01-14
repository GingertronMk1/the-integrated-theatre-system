<?php

declare(strict_types=1);

namespace App\Application\CrewRole\UpdateCrewRole;

use App\Application\CrewRole\CrewRoleModel;
use App\Domain\CrewRole\ValueObject\CrewRoleId;

final class Command
{
    public function __construct(
        public CrewRoleId $id,
        public string $name = '',
        public ?string $description = ''
    ) {
    }

    public static function forCrewRole(CrewRoleModel $model): self
    {
        return new self(
            $model->id,
            $model->name,
            $model->description
        );
    }
}
