<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryRepositoryInterface
{
    public function createTrainingCategory(string $name): void;

    public function updateTrainingCategory(TrainingCategoryId $id, string $name): void;
}
