<?php

declare(strict_types=1);

namespace App\Application\Season\CreateSeason;

use App\Domain\Common\ValueObject\Colour;

final class Command
{
    public function __construct(
        public string $name = '',
        public ?string $description = '',
        public ?Colour $colour = null,
    ) {
    }
}
