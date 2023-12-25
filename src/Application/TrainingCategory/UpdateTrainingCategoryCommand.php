<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

final class UpdateTrainingCategoryCommand
{
    public function __construct(
        public TrainingCategoryId $id,
        public string $name = ''
    ) {
    }

    public static function forCategory(TrainingCategoryEntity $category): self
    {
        return new self($category->id, $category->name);
    }
}
