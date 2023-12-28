<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryFinderInterface
{
    /**
     * @return array<TrainingCategoryModel>
     */
    public function findAll(): array;

    public function find(TrainingCategoryId $id): TrainingCategoryModel;
}
