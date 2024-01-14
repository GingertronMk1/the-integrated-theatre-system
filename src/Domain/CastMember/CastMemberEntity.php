<?php

declare(strict_types=1);

namespace App\Domain\CastMember;

use App\Domain\CastMember\ValueObject\CastMemberId;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\Show\ValueObject\ShowId;

final class CastMemberEntity
{
    public function __construct(
        public CastMemberId $id,
        public string $role,
        public PersonId $personId,
        public ShowId $showId
    ) {
    }
}
