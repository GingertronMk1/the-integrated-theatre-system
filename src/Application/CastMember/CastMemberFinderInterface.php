<?php

declare(strict_types=1);

namespace App\Application\CastMember;

use App\Domain\CastMember\ValueObject\CastMemberId;
use App\Domain\Show\ValueObject\ShowId;

interface CastMemberFinderInterface
{
    /**
     * @return array<CastMemberModel>
     */
    public function findAll(int $offset = null, int $limit = null): array;

    public function find(CastMemberId $id): CastMemberModel;

    public function count(CastMemberId $id = null): int;

    /**
     * @return array<CastMemberModel>
     */
    public function findForShow(ShowId $id): array;
}
