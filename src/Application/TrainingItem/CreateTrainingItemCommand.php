<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Domain\TrainingCategory\TrainingCategoryEntity;

class CreateTrainingItemCommand
{
    public function __construct(
        public string $name = '',
        public bool $isDangerous = false,
        public ?TrainingCategoryEntity $trainingCategory = null
    ) {
    }
}
