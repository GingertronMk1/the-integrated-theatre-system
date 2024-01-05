<?php

declare(strict_types=1);

namespace App\Domain\CastMember;

use App\Domain\CastMember\ValueObject\CastMemberId;

interface CastMemberRepositoryInterface
{
    public function getNextId(): CastMemberId;

    public function save(CastMemberEntity $entity): void;
}
