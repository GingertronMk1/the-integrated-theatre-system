<?php

declare(strict_types=1);

namespace App\Domain\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryFinderInterface
{
    public function findAll(): array;

    public function find(TrainingCategoryId $id): TrainingCategoryEntity;
}
