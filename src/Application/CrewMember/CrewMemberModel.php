<?php

declare(strict_types=1);

namespace App\Application\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;

final readonly class CrewMemberModel
{
    public function __construct(
        public CrewMemberId $id,
    ) {
    }
}
