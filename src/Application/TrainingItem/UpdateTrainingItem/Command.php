<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\UpdateTrainingItem;

use App\Application\TrainingItem\TrainingItemModel;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
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

    public static function forItem(TrainingItemModel $entity): self
    {
        return new self(
            $entity->id,
            $entity->trainingCategoryId,
            $entity->name,
            $entity->isDangerous
        );
    }
}
