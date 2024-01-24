<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Domain\Show\ValueObject\ShowId;

interface ShowFinderInterface
{
    /**
     * @return array<ShowModel>
     */
    public function findAll(int $offset = null, int $limit = null): array;

    public function find(ShowId $id): ShowModel;

    public function count(ShowId $id = null): int;
}
