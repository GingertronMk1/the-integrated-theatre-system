<?php

declare(strict_types=1);

namespace App\Domain\Show;

use App\Domain\Season\ValueObject\SeasonId;
use App\Domain\Show\ValueObject\ShowId;

final class ShowEntity
{
    public function __construct(
        public ShowId $id,
        public string $name,
        public ?string $description,
        public ?string $year,
        public ?SeasonId $seasonId
    ) {
    }
}
