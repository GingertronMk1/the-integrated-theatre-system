<?php

declare(strict_types=1);

namespace App\Application\TrainingCategory;

use App\Application\Fixtures\FixtureInterface;
use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;

final readonly class TrainingCategoryFixture implements FixtureInterface
{
    public function __construct(
        private TrainingCategoryRepositoryInterface $trainingCategoryRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getFixtures() as $fixture) {
            $this->trainingCategoryRepository->save($fixture);
        }
    }

    /** @return array<int, TrainingCategoryEntity> */
    public function getFixtures(): array
    {
        return [
            self::testCategoryFixture1(),
        ];
    }

    public static function testCategoryFixture1(): TrainingCategoryEntity
    {
        return new TrainingCategoryEntity(
            TrainingCategoryId::fromString('018cbad3-b98f-7974-846b-3a02b8333461'),
            'Test Category 1',
        );
    }
}
