<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingItemRepositoryInterface
{
    public function createTrainingItem(string $name, bool $isDangerous, TrainingCategoryId $trainingCategoryId): void;
}
