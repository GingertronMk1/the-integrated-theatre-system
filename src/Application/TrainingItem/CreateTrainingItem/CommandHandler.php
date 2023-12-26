<?php

declare(strict_types=1);

namespace App\Application\TrainingItem\CreateTrainingItem;

use App\Application\TrainingItem\TrainingItemRepositoryInterface;

class CommandHandler
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $this->trainingItemRepository->createTrainingItem($command->name, $command->isDangerous, $command->trainingCategory->id);
    }
}
