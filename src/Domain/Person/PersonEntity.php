<?php

declare(strict_types=1);

namespace App\Domain\Person;

use App\Domain\Person\ValueObject\PersonId;
use App\Domain\User\ValueObject\UserId;

final class PersonEntity
{
    public function __construct(
        public PersonId $id,
        public string $name,
        public string $bio,
        public string $startYear,   // TODO: create stringable year value object
        public string $endYear,
        public UserId $userId,
    ) {
    }
}
