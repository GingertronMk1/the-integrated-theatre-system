<?php

declare(strict_types=1);

namespace App\Domain\TrainingItem;

use App\Domain\TrainingItem\ValueObject\TrainingItemId;

interface TrainingItemRepositoryInterface
{
    public function getNextId(): TrainingItemId;

    public function save(TrainingItemEntity $entity): void;
}
