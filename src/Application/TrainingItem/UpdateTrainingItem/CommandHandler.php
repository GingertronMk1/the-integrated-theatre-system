<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\UpdateTrainingItem;

use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $trainingItemEntity = new TrainingItemEntity(
            $command->id,
            $command->name,
            $command->isDangerous,
            $command->trainingCategoryId,
        );

        $this->trainingItemRepository->updateTrainingItem($trainingItemEntity);
    }
}
