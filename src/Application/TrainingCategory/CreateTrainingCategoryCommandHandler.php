<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

final readonly class CreateTrainingCategoryCommandHandler
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function handle(CreateTrainingCategoryCommand $command): void
    {
        $this->trainingCategoryRepository->createTrainingCategory($command->name);
    }
}
