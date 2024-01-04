<?php

declare(strict_types=1);

namespace App\Application\CrewMember\UpdateCrewMember;

use App\Application\CrewMember\CrewMemberModel;
use App\Domain\CrewMember\ValueObject\CrewMemberId;

final class Command
{
    public function __construct(
        public CrewMemberId $id,
    ) {
    }

    public static function forCrewMember(CrewMemberModel $command): self
    {
        return new self(
            $command->id,
        );
    }
}
