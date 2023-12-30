<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingSession;

use Doctrine\DBAL\Connection;


class DbalTrainingSessionFinder {
        public function __construct(
                private readonly \Doctrine\DBAL\Connection $connection
            ) {}
    }
