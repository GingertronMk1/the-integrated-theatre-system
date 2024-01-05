<?php

declare(strict_types=1);

namespace App\Domain\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;
use App\Domain\CrewRole\ValueObject\CrewRoleId;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\Show\ValueObject\ShowId;

final class CrewMemberEntity
{
    public function __construct(
        public CrewMemberId $id,
        public PersonId $personId,
        public CrewRoleId $crewRoleId,
        public string $notes,
        public ShowId $showId
    ) {
    }
}
