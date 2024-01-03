<?php

declare(strict_types=1);

namespace App\Domain\Show;

use App\Domain\Show\ValueObject\ShowId;

interface ShowRepositoryInterface
{
    public function getNextId(): ShowId;

    public function createShow(ShowEntity $category): void;

    public function updateShow(ShowEntity $category): void;
}
