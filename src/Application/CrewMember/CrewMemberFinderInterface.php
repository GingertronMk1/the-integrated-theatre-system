<?php

declare(strict_types=1);

namespace App\Application\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;

interface CrewMemberFinderInterface
{
    /**
     * @return array<CrewMemberModel>
     */
    public function findAll(): array;

    public function find(CrewMemberId $id): CrewMemberModel;
}
