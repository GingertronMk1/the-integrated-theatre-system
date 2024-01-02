<?php

declare(strict_types=1);

namespace App\Application\Show\CreateShow;

final class Command
{
    public function __construct(
        public string $name = '',
        public string $description = '',
        public string $year = '',
        public string $semester = '',
        public string $season = '',
    ) {
    }
}
