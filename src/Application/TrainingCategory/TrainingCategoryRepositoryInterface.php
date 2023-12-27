<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryRepositoryInterface
{
    public function getNextId(): TrainingCategoryId;

    public function createTrainingCategory(TrainingCategoryEntity $category): void;

    public function updateTrainingCategory(TrainingCategoryEntity $category): void;
}
