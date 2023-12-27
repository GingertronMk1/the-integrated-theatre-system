<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use App\Application\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;

final class TrainingItemFixture implements FixtureInterface
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getAllFixtures() as $fixture) {
            $this->trainingItemRepository->createTrainingCategory($fixture);
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
