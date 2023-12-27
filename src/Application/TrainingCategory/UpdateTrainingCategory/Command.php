<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\UpdateTrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryModel;
use App\Domain\TrainingCategory\TrainingCategoryEntity;

final class Command
{
    public function __construct(
        public TrainingCategoryEntity $category,
        public string $name = ''
    ) {
    }

    public static function forCategory(TrainingCategoryModel $category): self
    {
        $categoryEntity = new TrainingCategoryEntity(
            $category->id,
            $category->name
        );
        return new self($categoryEntity, $category->name);
    }
}
