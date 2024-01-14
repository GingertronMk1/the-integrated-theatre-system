<?php

declare(strict_types=1);

namespace App\Application\CastMember;

use App\Application\Person\PersonModel;
use App\Domain\CastMember\ValueObject\CastMemberId;

final readonly class CastMemberModel
{
    public function __construct(
        public CastMemberId $id,
        public string $role,
        public PersonModel $person
    ) {
    }
}
