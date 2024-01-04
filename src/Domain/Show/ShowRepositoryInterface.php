<?php

declare(strict_types=1);

namespace App\Domain\Show;

use App\Domain\Show\ValueObject\ShowId;

interface ShowRepositoryInterface
{
    public function getNextId(): ShowId;

    public function save(ShowEntity $category): void;
}
