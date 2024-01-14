<?php

declare(strict_types=1);

namespace App\Application\CrewMember\CreateCrewMember;

use App\Application\CrewRole\CrewRoleModel;
use App\Application\Person\PersonModel;
use App\Application\Show\ShowModel;
use App\Domain\Show\ValueObject\ShowId;

final class Command
{
    public function __construct(
        public ShowId $showId,
        public ?PersonModel $person = null,
        public ?CrewRoleModel $crewRole = null,
        public string $notes = ''
    ) {
    }

    public static function forShow(ShowModel $show): self
    {
        return new self(
            $show->id
        );
    }
}
