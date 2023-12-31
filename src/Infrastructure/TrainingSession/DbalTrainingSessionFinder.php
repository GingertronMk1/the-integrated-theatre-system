<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Application\Person\PersonFinderInterface;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingSession\TrainingSessionFinderInterface;
use App\Application\TrainingSession\TrainingSessionModel;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionPersonType;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingSessionFinder implements TrainingSessionFinderInterface
{
    public function __construct(
        private Connection $connection,
        private TrainingItemFinderInterface $trainingItemFinder,
        private PersonFinderInterface $personFinder
    ) {
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
          ->select('*')
          ->from('training_sessions')
          ->fetchAllAssociative();

        return array_map(
            fn (array $row) => $this->createSessionFromRow($row),
            $rows
        );
    }

    private function createSessionFromRow(array $row): TrainingSessionModel
    {
        $thisId = TrainingSessionId::fromString($row['id']);
        $itemFinderQb = $this->connection->createQueryBuilder();
        $itemIds = $itemFinderQb
          ->select('training_item_id')
          ->from('training_session_items')
          ->where('training_session_id = :training_session_id')
          ->setParameter('training_session_id', (string) $thisId)
          ->fetchFirstColumn();

        $items = array_map(fn (string $str) => $this->trainingItemFinder->find(TrainingItemId::fromString($str)), $itemIds);
        $people = [];

        foreach (TrainingSessionPersonType::cases() as $type) {
            $personFinderQb = $this->connection->createQueryBuilder();
            $personIds = $personFinderQb
              ->select('person_id')
              ->from('training_session_people')
              ->where(
                  $personFinderQb->expr()->and(
                      $personFinderQb->expr()->eq('training_session_id', ':training_session_id'),
                      $personFinderQb->expr()->eq('type', ':type')
                  )
              )
                ->setParameters([
                  'training_session_id' => $thisId,
                  'type' => $type->value,
                ])
                ->fetchFirstColumn();

            $people[$type->value] = array_map(
                fn (string $id) => $this->personFinder->findById(PersonId::fromString($id)),
                $personIds
            );
        }

        return new TrainingSessionModel(
            $thisId,
            new DateTimeImmutable($row['occurred_at']),
            $items,
            $people[TrainingSessionPersonType::TYPE_TRAINER->value],
            $people[TrainingSessionPersonType::TYPE_TRAINEE->value],
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
