<?php

declare(strict_types=1);

namespace App\Domain\TrainingItem;

use App\Domain\TrainingItem\ValueObject\TrainingItemId;

interface TrainingItemFinderInterface
{
    public function findAll(): array;

    public function find(TrainingItemId $id): TrainingItemEntity;
}
