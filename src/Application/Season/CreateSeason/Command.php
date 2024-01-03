<?php

declare(strict_types=1);

namespace App\Application\Season\CreateSeason;

final class Command
{
    public function __construct(
        public string $name = '',
        public ?string $description = '',
        public string $colour = '',
    ) {
    }
}
