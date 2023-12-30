<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use App\Application\TrainingSession\TrainingSessionFinderInterface;
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
        
        return $rows;
    }
}
