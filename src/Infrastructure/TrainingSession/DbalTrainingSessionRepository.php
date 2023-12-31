<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Domain\TrainingSession\TrainingSessionEntity;
use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionPersonType;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingSessionRepository implements TrainingSessionRepositoryInterface
{
    private const SESSIONS_TABLE = 'training_sessions';

    public function __construct(
        private Connection $connection,
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

        $this
            ->connection
            ->createQueryBuilder()
            ->delete('training_session_items')
            ->where('training_session_id = :training_session_id')
            ->setParameter('training_session_id', (string) $session->id)
            ->executeStatement()
        ;
        $this
            ->connection
            ->createQueryBuilder()
            ->delete('training_session_people')
            ->where('training_session_id = :training_session_id')
            ->setParameter('training_session_id', (string) $session->id)
            ->executeStatement()
        ;
        foreach ($session->items as $item) {
            $this
                ->connection
                ->createQueryBuilder()
                ->insert('training_session_items')
                ->values([
                    'training_session_id' => ':training_session_id',
                    'training_item_id' => ':training_item_id',
                ])
                ->setParameters([
                    'training_session_id' => (string) $session->id,
                    'training_item_id' => (string) $item,
                ])
                ->executeStatement();
        }
        foreach ([
          TrainingSessionPersonType::TYPE_TRAINER->value => $session->trainers,
          TrainingSessionPersonType::TYPE_TRAINEE->value => $session->trainees,
        ] as $type => $people) {
            foreach ($people as $person) {
                $this
                    ->connection
                    ->createQueryBuilder()
                    ->insert('training_session_people')
                    ->values([
                        'training_session_id' => ':training_session_id',
                        'person_id' => ':person_id',
                        'type' => ':type',
                    ])
                    ->setParameters([
                        'training_session_id' => (string) $session->id,
                        'person_id' => (string) $person,
                        'type' => $type,
                    ])
                    ->executeStatement();
            }
        }
    }
}
