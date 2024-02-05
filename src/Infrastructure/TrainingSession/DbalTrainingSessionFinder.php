<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Application\Person\PersonFinderInterface;
use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingSession\TrainingSessionFinderInterface;
use App\Application\TrainingSession\TrainingSessionModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Domain\TrainingSession\TrainingSessionException;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionPersonType;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalTrainingSessionFinder extends AbstractDbalFinder implements TrainingSessionFinderInterface
{
    public function __construct(
        private Connection $connection,
        private TrainingItemFinderInterface $trainingItemFinder,
        private PersonFinderInterface $personFinder
    ) {
    }

    public function findAll(?int $offset = null, ?int $limit = null): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    public function find(TrainingSessionId $id): TrainingSessionModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
          ->select('*')
          ->from($this->getTable())
          ->where('id = :id')
          ->setParameter('id', (string) $id)
          ->fetchAssociative();

        if (!is_array($row)) {
            throw TrainingSessionException::notFoundWithId($id);
        }

        return $this->createFromRow($row);
    }

    /**
     * @param array<string, string> $row
     */
    protected function createFromRow(array $row): TrainingSessionModel
    {
        $thisId = TrainingSessionId::fromString($row['id']);
        $itemFinderQb = $this->connection->createQueryBuilder();
        $itemIds = $itemFinderQb
          ->select('training_item_id')
          ->from('training_session_items')
          ->where('training_session_id = :training_session_id')
          ->setParameter('training_session_id', (string) $thisId)
          ->fetchFirstColumn();

        $items = $this->trainingItemFinder->findAll(
            array_map(fn (string $str) => TrainingItemId::fromString($str),
                $itemIds
            ));
        $people = [];

        foreach (TrainingSessionPersonType::cases() as $type) {
            $personFinderQb = $this->connection->createQueryBuilder();
            $personIds = $personFinderQb
                ->select('person_id')
                ->from('training_session_people')
                ->where('training_session_id = :training_session_id')
                ->andWhere('type = :type')
                ->setParameters([
                    'training_session_id' => $thisId,
                    'type' => $type->value,
                ])
                ->fetchFirstColumn();

            $people[$type->value] = $this->personFinder->findAll(
                array_map(
                    fn (string $str) => PersonId::fromString($str),
                    $personIds
                ));
        }

        return new TrainingSessionModel(
            $thisId,
            DateTime::fromString($row['occurred_at']),
            $items,
            $people[TrainingSessionPersonType::TYPE_TRAINER->value],
            $people[TrainingSessionPersonType::TYPE_TRAINEE->value],
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
        );
    }

    protected function getTable(): string
    {
        return 'training_sessions';
    }

    public function count(?TrainingSessionId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
