<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Domain\TrainingSession\TrainingSessionEntity;
use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class DbalTrainingSessionRepository implements TrainingSessionRepositoryInterface
{
    private const SESSIONS_TABLE = 'training_sessions';

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
        $finderQb = $this->connection->createQueryBuilder();
        $count = $finderQb
            ->select('COUNT(*)')
            ->from(self::SESSIONS_TABLE)
            ->where('id = :id')
            ->setParameter('id', (string) $session->id)
            ->fetchOne();

        $now = (new DateTimeImmutable())->format('c');
        $upsertQb = $this->connection->createQueryBuilder();
        if (0 === $count) {
            $upsertQb
                ->insert(self::SESSIONS_TABLE)
                ->values([
                    'id' => ':id',
                    'occurred_at' => ':occurred_at',
                    'created_at' => ':now',
                    'updated_at' => ':now',
                ])
            ;
        } else {
            $upsertQb
                ->update(self::SESSIONS_TABLE)
                ->set('occurred_at', ':occurred_at')
                ->set('updated_at', ':now')
                ->where('id = :id')
            ;
        }
        $upsertQb->setParameters([
            'id' => (string) $session->id,
            'occurred_at' => $session->occurredAt->format('c'),
            'now' => $now,
        ])
        ->executeStatement();
    }
}
