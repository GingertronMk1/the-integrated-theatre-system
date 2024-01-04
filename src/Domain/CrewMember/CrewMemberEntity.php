<?php

declare(strict_types=1);

namespace App\Domain\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;

final class CrewMemberEntity
{
    public function __construct(
        public CrewMemberId $id,
    ) {
    }
}
