<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

final class CreateTrainingCategoryCommand
{
    public function __construct(
        public string $name = ''
    )
    {
    }
}
