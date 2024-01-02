<?php

declare(strict_types=1);

namespace App\Application\Season;

use App\Domain\Season\ValueObject\SeasonId;

final readonly class SeasonModel
{
    public function __construct(
        public SeasonId $id,
    ) {
    }
}
