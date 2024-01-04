<?php

declare(strict_types=1);

namespace App\Domain\Person;

use App\Domain\Person\ValueObject\PersonId;

interface PersonRepositoryInterface
{
    public function getNextId(): PersonId;

    public function save(PersonEntity $entity): void;
}
