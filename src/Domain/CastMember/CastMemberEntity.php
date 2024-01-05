<?php

declare(strict_types=1);

namespace App\Domain\CastMember;

use App\Domain\CastMember\ValueObject\CastMemberId;

final class CastMemberEntity
{
    public function __construct(
        public CastMemberId $id,
    ) {
    }
}
