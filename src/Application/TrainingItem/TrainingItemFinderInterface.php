<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Domain\TrainingItem\ValueObject\TrainingItemId;

interface TrainingItemFinderInterface
{
    /**
     * @return array<TrainingItemModel>
     */
    public function findAll(): array;

    public function find(TrainingItemId $id): TrainingItemModel;

    public function findByName(string $name): TrainingItemModel;
}
