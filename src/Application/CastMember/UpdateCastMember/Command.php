<?php

declare(strict_types=1);

namespace App\Application\CastMember\UpdateCastMember;

use App\Application\CastMember\CastMemberModel;
use App\Domain\CastMember\ValueObject\CastMemberId;

final class Command
{
    public function __construct(
        public CastMemberId $id,
    ) {
    }

    public static function forCastMember(CastMemberModel $command): self
    {
        return new self(
            $command->id,
        );
    }
}
