<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\CreateTrainingCategory;

final class Command
{
    public function __construct(
        public string $name = ''
    ) {
    }
}
