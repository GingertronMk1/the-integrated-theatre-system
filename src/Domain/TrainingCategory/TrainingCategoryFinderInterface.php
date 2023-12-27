<?php

declare(strict_types=1);

namespace App\Domain\TrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryModel;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryFinderInterface
{
    /**
     * @return array<TrainingCategoryModel>
     */
    public function findAll(): array;

    public function find(TrainingCategoryId $id): TrainingCategoryModel;
}
