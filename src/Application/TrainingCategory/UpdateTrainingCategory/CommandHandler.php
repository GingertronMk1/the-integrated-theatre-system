<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\UpdateTrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;

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
        );
        $this->trainingCategoryRepository->save($newCategory);
    }
}
