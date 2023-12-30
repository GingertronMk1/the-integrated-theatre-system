<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use Doctrine\DBAL\Connection;

class DbalTrainingSessionRepository
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }
}
