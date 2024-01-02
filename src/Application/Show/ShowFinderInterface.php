<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Domain\Show\ValueObject\ShowId;

interface ShowFinderInterface
{
    /**
     * @return array<ShowModel>
     */
    public function findAll(): array;

    public function find(ShowId $id): ShowModel;
}
