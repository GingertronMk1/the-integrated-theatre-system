<?php

declare(strict_types=1);

namespace App\Application\TrainingItem;

use App\Application\Fixtures\DependentFixtureInterface;
use App\Application\TrainingCategory\TrainingCategoryFixture;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemRepositoryInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;

final readonly class TrainingItemFixture implements DependentFixtureInterface
{
    public function __construct(
        private TrainingItemRepositoryInterface $trainingItemRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getFixtures() as $fixture) {
            $this->trainingItemRepository->save($fixture);
        }
    }

    public function getDependencies(): array
    {
        return [TrainingCategoryFixture::class];
    }

    /** @return array<int, TrainingItemEntity> */
    private function getFixtures(): array
    {
        return [
          self::getTestFixture(),
          self::getSessionTestFixture(),
        ];
    }

    public static function getTestFixture(): TrainingItemEntity
    {
        return new TrainingItemEntity(
            TrainingItemId::fromString('018cad80-4a49-738a-8976-be8a62a5f235'),
            'Test Item 1',
            false,
            TrainingCategoryFixture::testCategoryFixture1()->id
        );
    }

    public static function getSessionTestFixture(): TrainingItemEntity
    {
        return new TrainingItemEntity(
            TrainingItemId::fromString('018cc021-be3f-749f-9d56-ef70c52d60b4'),
            'Session Item',
            true,
            TrainingCategoryFixture::testCategoryFixture1()->id
        );
    }
}
