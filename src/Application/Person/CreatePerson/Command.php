<?php

declare(strict_types=1);

namespace App\Application\Person\CreatePerson;

use App\Application\User\UserModel;
use App\Domain\User\ValueObject\UserId;

class Command
{
    public function __construct(
        public string $name = '',
        public ?string $bio = '',
        public ?int $startYear = null,   // TODO: create stringable year value object
        public ?int $endYear = null,
        public ?UserModel $user = null,
    ) {
    }
}
