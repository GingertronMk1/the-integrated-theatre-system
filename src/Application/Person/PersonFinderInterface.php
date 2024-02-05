<?php

declare(strict_types=1);

namespace App\Application\Person;

use App\Domain\Person\ValueObject\PersonId;

interface PersonFinderInterface
{
    public function find(PersonId $id): PersonModel;

    /**
     * @param array<PersonId> $ids
     *
     * @return array<PersonModel>
     */
    public function findAll(array $ids = [], int $offset = null, int $limit = null): array;

    public function count(PersonId $id = null): int;
}
