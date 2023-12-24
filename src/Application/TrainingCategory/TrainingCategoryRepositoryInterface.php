<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

interface TrainingCategoryRepositoryInterface
{
    public function createTrainingCategory(string $name): void;
}
