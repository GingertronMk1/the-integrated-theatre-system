<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

class CreateTrainingItemCommandHandler
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function handle(CreateTrainingItemCommand $command): void
    {
        $this->trainingItemRepository->createTrainingItem($command->name, $command->isDangerous, $command->trainingCategory->id);
    }
}
