<?php

declare(strict_types=1);

namespace App\Application\Person\UpdatePerson;

use App\Application\Person\PersonModel;
use App\Application\User\UserModel;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\User\ValueObject\UserId;

class Command
{
    public function __construct(
        public PersonId $id,
        public string $name = '',
        public ?string $bio = '',
        public ?int $startYear = null,   // TODO: create stringable year value object
        public ?int $endYear = null,
        public ?UserModel $user = null,
    ) {
    }

    public static function forPerson(PersonModel $person): self
    {
        return new self(
            $person->id,
            $person->name,
            $person->bio,
            $person->startYear,
            $person->endYear,
            $person->user
        );
    }
}
