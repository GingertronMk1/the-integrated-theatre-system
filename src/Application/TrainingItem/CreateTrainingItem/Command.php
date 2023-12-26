<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\CreateTrainingItem;

use App\Domain\TrainingCategory\TrainingCategoryEntity;

class Command
{
    public function __construct(
        public string $name = '',
        public bool $isDangerous = false,
        public ?TrainingCategoryEntity $trainingCategory = null
    ) {
    }
}
