<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\CreateTrainingItem;

use App\Application\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\TrainingItemEntity;

class CommandHandler
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $item = new TrainingItemEntity(
            $this->trainingItemRepository->getNextId(),
            $command->name,
            $command->isDangerous,
            $command->trainingCategoryId
        );
        $this->trainingItemRepository->createTrainingItem($item);
    }
}
