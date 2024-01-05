<?php

declare(strict_types=1);

namespace App\Application\CastMember;

use App\Domain\CastMember\ValueObject\CastMemberId;

interface CastMemberFinderInterface
{
    /**
     * @return array<CastMemberModel>
     */
    public function findAll(): array;

    public function find(CastMemberId $id): CastMemberModel;
}
