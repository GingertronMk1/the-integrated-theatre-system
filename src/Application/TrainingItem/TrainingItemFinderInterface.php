<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Domain\TrainingItem\ValueObject\TrainingItemId;

interface TrainingItemFinderInterface
{
    /**
     * @param array<TrainingItemId> $ids
     *
     * @return array<TrainingItemModel>
     */
    public function findAll(array $ids = []): array;

    public function find(TrainingItemId $id): TrainingItemModel;

    public function findByName(string $name): TrainingItemModel;

    public function count(?TrainingItemId $id = null): int;
}
