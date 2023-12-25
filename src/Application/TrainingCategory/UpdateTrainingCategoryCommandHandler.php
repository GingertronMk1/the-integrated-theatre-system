<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

final readonly class UpdateTrainingCategoryCommandHandler
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function handle(UpdateTrainingCategoryCommand $command): void
    {
        $this->trainingCategoryRepository->updateTrainingCategory($command->id, $command->name);
    }
}
