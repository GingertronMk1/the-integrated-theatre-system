<?php

declare(strict_types=1);

namespace App\Domain\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryRepositoryInterface
{
    public function getNextId(): TrainingCategoryId;

    public function save(TrainingCategoryEntity $category): void;
}
