<?php

declare(strict_types=1);

namespace App\Domain\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;

interface CrewMemberRepositoryInterface
{
    public function getNextId(): CrewMemberId;

    public function save(CrewMemberEntity $entity): void;
}
