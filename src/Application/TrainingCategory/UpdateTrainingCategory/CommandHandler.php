<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory\UpdateTrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function handle(Command $command): TrainingCategoryId
    {
        $newCategory = new TrainingCategoryEntity(
            $command->category->id,
            $command->name,
        );
        $this->trainingCategoryRepository->save($newCategory);

        return $command->category->id;
    }
}
