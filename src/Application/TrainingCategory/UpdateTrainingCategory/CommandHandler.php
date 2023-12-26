<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\UpdateTrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $this->trainingCategoryRepository->updateTrainingCategory($command->id, $command->name);
    }
}
