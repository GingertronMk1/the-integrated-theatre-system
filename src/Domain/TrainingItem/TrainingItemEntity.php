<?php

declare(strict_types=1);

namespace App\Domain\TrainingItem;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;

final class TrainingItemEntity
{
    public function __construct(
        public TrainingItemId $id,
        public string $name,
        public bool $isDangerous,
        public TrainingCategoryId $trainingCategoryId,
    ) {
    }
}
