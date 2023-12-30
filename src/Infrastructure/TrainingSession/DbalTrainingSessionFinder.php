<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Application\TrainingSession\TrainingSessionFinderInterface;
use App\Application\TrainingSession\TrainingSessionModel;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

class DbalTrainingSessionFinder implements TrainingSessionFinderInterface
{
    public function __construct(
        private readonly Connection $connection
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
        return new TrainingSessionModel(
            TrainingSessionId::fromString($row['id']),
            new DateTimeImmutable($row['occurred_at']),
            [],
            [],
            [],
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
