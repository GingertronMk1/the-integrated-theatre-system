<?php

declare(strict_types=1);

namespace App\Application\Person;

use App\Domain\Person\ValueObject\PersonId;

interface PersonFinderInterface
{
    public function findById(PersonId $id): PersonModel;

    /** @return array<PersonModel> */
    public function findAll(): array;
}
