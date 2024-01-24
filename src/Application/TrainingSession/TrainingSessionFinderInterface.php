<?php

declare(strict_types=1);

namespace App\Application\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

interface TrainingSessionFinderInterface
{
    public function find(TrainingSessionId $id): TrainingSessionModel;

    /**
     * @return array<TrainingSessionModel>
     */
    public function findAll(int $offset = null, int $limit = null): array;

    public function count(TrainingSessionId $id = null): int;
}
