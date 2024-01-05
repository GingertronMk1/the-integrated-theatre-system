<?php

declare(strict_types=1);

namespace App\Application\CrewMember;

use App\Domain\CrewMember\ValueObject\CrewMemberId;
use App\Domain\Show\ValueObject\ShowId;

interface CrewMemberFinderInterface
{
    /**
     * @return array<CrewMemberModel>
     */
    public function findAll(): array;

    public function find(CrewMemberId $id): CrewMemberModel;

    /**
     * @return array<CrewMemberModel>
     */
    public function findForShow(ShowId $showId): array;
}
