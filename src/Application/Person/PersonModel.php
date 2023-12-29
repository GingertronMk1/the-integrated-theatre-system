<?php

declare(strict_types=1);

namespace App\Application\Person;

use App\Application\User\UserModel;
use App\Domain\Person\ValueObject\PersonId;

final readonly class PersonModel
{
    public function __construct(
        public PersonId $id,
        public string $name,
        public string $bio,
        public ?int $startYear,
        public ?int $endYear,
        public ?UserModel $user
    ) {
    }
}
