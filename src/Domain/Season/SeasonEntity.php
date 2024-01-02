<?php

declare(strict_types=1);

namespace App\Domain\Season;

use App\Domain\Season\ValueObject\SeasonId;

final class SeasonEntity
{
    public function __construct(
        public SeasonId $id,
    ) {
    }
}
