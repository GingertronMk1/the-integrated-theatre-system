<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\CreateTrainingItem;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

class Command
{
    public function __construct(
        public string $name = '',
        public bool $isDangerous = false,
        public ?TrainingCategoryId $trainingCategoryId = null
    ) {
    }
}
