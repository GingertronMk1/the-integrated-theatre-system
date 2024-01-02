<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Domain\Show\ValueObject\ShowId;

final readonly class ShowModel
{
    public function __construct(
        public ShowId $id,
    ) {
    }
}
