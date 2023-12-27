<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use App\Application\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;

final class TrainingItemFixture implements DependantFixtureInterface
{
    public function __construct(
        private readonly TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getAllFixtures() as $fixture) {
            $this->trainingItemRepository->createTrainingItem($fixture);
        }
    }

    private function getAllFixtures(): array
    {
        return [
            new TrainingItemEntity(
                TrainingItemId::fromString('018cace9-edc1-74bf-bc8f-582b4a68a3ac'),
                'Training Item 1',
                true,
                TrainingCategoryId::fromString('018cab99-f343-7faa-9bf4-1f43cadb86c5'),
            ),
        ];
    }

    public function getDependencies(): array
    {
        return [
            TrainingCategoryFixture::class,
        ];
    }
}
