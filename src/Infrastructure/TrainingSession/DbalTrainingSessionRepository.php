<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use Doctrine\DBAL\Connection;

class DbalTrainingSessionRepository implements TrainingSessionRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function getNextId(): TrainingSessionId
    {
      return TrainingSessionId::generate();
    }
}
