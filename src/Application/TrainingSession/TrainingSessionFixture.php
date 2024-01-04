<?php

declare(strict_types=1);

namespace App\Application\TrainingSession;

use App\Application\Fixtures\DependentFixtureInterface;
use App\Application\Person\PersonFixture;
use App\Application\TrainingItem\TrainingItemFixture;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingSession\TrainingSessionEntity;
use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

final readonly class TrainingSessionFixture implements DependentFixtureInterface
{
    public function __construct(
        private TrainingSessionRepositoryInterface $trainingSessionRepository
    ) {
    }

    public function load(): void
    {
        foreach ($this->getAllFixtures() as $fixture) {
            $this->trainingSessionRepository->save($fixture);
        }
    }

    /**
     * @return array<TrainingSessionEntity>
     */
    private function getAllFixtures(): array
    {
        return [
          self::getTestSession1(),
        ];
    }

    public static function getTestSession1(): TrainingSessionEntity
    {
        return new TrainingSessionEntity(
            TrainingSessionId::fromString('018cbfc8-72c2-7f2b-9732-3e7d214f35f7'),
            DateTime::fromString('2023-12-25 09:00:00'),
            [TrainingItemFixture::getTestFixture()->id],
            [PersonFixture::testPerson1()->id],
            [PersonFixture::testPerson2()->id],
        );
    }

    public function getDependencies(): array
    {
        return [PersonFixture::class, TrainingItemFixture::class];
    }
}
