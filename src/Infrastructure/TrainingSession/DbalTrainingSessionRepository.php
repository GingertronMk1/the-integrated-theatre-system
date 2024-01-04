<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Application\Common\Service\ClockInterface;
use App\Domain\TrainingSession\TrainingSessionEntity;
use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionPersonType;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;

final class DbalTrainingSessionRepository extends AbstractDbalRepository implements TrainingSessionRepositoryInterface
{
    protected function getTable(): string
    {
        return 'training_sessions';
    }

    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock
    ) {
    }

    public function getNextId(): TrainingSessionId
    {
        return TrainingSessionId::generate();
    }

    public function save(TrainingSessionEntity $session): void
    {
        $this->connection->transactional(function (Connection $conn) use ($session) {
            $count = $this->getCount($this->connection, $session->id);

            $upsertQb = $this->connection->createQueryBuilder();
            if (0 === $count) {
                $upsertQb
                    ->insert($this->getTable())
                    ->values([
                        'id' => ':id',
                        'occurred_at' => ':occurred_at',
                        'created_at' => ':now',
                        'updated_at' => ':now',
                    ])
                ;
            } else {
                $upsertQb
                    ->update($this->getTable())
                    ->set('occurred_at', ':occurred_at')
                    ->set('updated_at', ':now')
                    ->where('id = :id')
                ;
            }
            $upsertQb->setParameters([
                'id' => (string) $session->id,
                'occurred_at' => (string) $session->occurredAt,
                'now' => (string) $this->clock->getCurrentTime(),
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
        });
    }
}
