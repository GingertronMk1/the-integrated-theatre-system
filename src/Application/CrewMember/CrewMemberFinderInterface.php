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
    public function findAll(?int $offset = null, ?int $limit = null): array;

    public function find(CrewMemberId $id): CrewMemberModel;

    public function count(?CrewMemberId $id = null): int;

    /**
     * @return array<CrewMemberModel>
     */
    public function findForShow(ShowId $showId): array;
}
