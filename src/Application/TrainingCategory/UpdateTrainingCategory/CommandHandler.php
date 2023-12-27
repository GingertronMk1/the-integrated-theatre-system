<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\UpdateTrainingCategory;

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
        $newCategory = new TrainingCategoryEntity(
            $command->category->id,
            $command->name,
            $command->category->createdAt,
            new DateTimeImmutable()
        );
        $this->trainingCategoryRepository->updateTrainingCategory($newCategory);
    }
}
