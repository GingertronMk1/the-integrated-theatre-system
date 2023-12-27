<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\CreateTrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
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
            new DateTimeImmutable(),
            new DateTimeImmutable(),
        );
        $this->trainingCategoryRepository->createTrainingCategory($category);
    }
}
