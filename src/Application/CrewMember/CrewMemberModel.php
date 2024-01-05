<?php

declare(strict_types=1);

namespace App\Application\CrewMember;

use App\Application\CrewRole\CrewRoleModel;
use App\Application\Person\PersonModel;
use App\Domain\CrewMember\ValueObject\CrewMemberId;

final readonly class CrewMemberModel
{
    public function __construct(
        public CrewMemberId $id,
        public PersonModel $person,
        public CrewRoleModel $role,
        public string $notes
    ) {
    }
}
