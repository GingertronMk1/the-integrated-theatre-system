<?php

declare(strict_types=1);

namespace App\Domain\Season;

use App\Domain\Season\ValueObject\SeasonId;

interface SeasonRepositoryInterface
{
    public function getNextId(): SeasonId;

    public function save(SeasonEntity $entity): void;
}
