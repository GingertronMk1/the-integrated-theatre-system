<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\CreateTrainingItem;

use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;

final readonly class CommandHandler
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function handle(Command $command): TrainingItemId
    {
        $id = $this->trainingItemRepository->getNextId();
        $item = new TrainingItemEntity(
            $id,
            $command->name,
            $command->isDangerous,
            $command->trainingCategoryId
        );
        $this->trainingItemRepository->save($item);

        return $id;
    }
}
