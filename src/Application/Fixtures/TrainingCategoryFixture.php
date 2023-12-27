<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use App\Application\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;

final class TrainingCategoryFixture extends AbstractFixture
{
    public function __construct(
        private readonly TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getAllFixtures() as $fixture) {
            $this->trainingCategoryRepository->createTrainingCategory($fixture);
        }
    }

    public function getAllFixtures(): array
    {
        return [
            new TrainingCategoryEntity(
                TrainingCategoryId::fromString('018cab99-f343-7faa-9bf4-1f43cadb86c5'),
                'TC 1',
                new DateTimeImmutable(),
                new DateTimeImmutable(),
            ),
        ];
    }
}
