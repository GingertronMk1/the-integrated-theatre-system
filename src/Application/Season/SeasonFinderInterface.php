<?php

declare(strict_types=1);

namespace App\Application\Season;

use App\Domain\Season\ValueObject\SeasonId;

interface SeasonFinderInterface
{
    /**
     * @return array<SeasonModel>
     */
    public function findAll(): array;

    public function find(SeasonId $id): SeasonModel;
}
