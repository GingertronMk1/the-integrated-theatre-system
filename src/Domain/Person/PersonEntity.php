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
        public ?string $bio,
        public ?int $startYear,   // TODO: create stringable year value object
        public ?int $endYear,
        public ?UserId $userId,
    ) {
    }
}
