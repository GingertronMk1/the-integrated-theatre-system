<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Domain\TrainingSession\TrainingSessionEntity;
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

    public function saveSession(TrainingSessionEntity $session): void
    {
        $finderQB = $this->connection->createQueryBuilder();
        $count = $finderQB
            ->select('COUNT(*)')
            ->from('training_sessions')
            ->where('id = :id')
            ->setParameter('id', (string) $session->id)
            ->fetchOne();
    }
}
