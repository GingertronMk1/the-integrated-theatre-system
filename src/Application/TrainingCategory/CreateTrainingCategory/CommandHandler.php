<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\CreateTrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use DateTimeImmutable;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $id = $this->trainingCategoryRepository->getNextId();
        $category = new TrainingCategoryEntity(
            $id,
            $command->name,
        );
        $this->trainingCategoryRepository->createTrainingCategory($category);
    }
}
