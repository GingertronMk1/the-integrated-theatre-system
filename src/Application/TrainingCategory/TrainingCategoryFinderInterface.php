<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

interface TrainingCategoryFinderInterface
{
    /**
     * @return array<TrainingCategoryModel>
     */
    public function findAll(?int $offset = null, ?int $limit = null): array;

    public function find(TrainingCategoryId $id): TrainingCategoryModel;

    public function count(?TrainingCategoryId $id = null): int;
}
