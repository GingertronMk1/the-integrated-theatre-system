<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\UpdateTrainingItem;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;

class Command
{
    public function __construct(
        public TrainingItemId $id,
        public TrainingCategoryId $trainingCategoryId,
        public string $name = '',
        public bool $isDangerous = false,
    ) {
    }

    public static function forItem(TrainingItemEntity $entity): self
    {
        return new self($entity->id, $entity->trainingCategoryId, $entity->name, $entity->isDangerous);
    }
}
