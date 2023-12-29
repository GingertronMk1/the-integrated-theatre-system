<?php

declare(strict_types=1);

namespace App\Application\Person;

use App\Domain\Person\ValueObject\PersonId;
use App\Domain\User\ValueObject\UserId;

final readonly class PersonModel
{
    public function __construct(
        public PersonId $id,
        public string $name,
        public string $bio,
        public ?int $startYear,
        public ?int $endYear,
        public ?UserId $userId
    ) {
    }
}
