<?php

declare(strict_types=1);

namespace App\Application\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

interface TrainingSessionFinderInterface
{
    public function find(TrainingSessionId $id): TrainingSessionModel;

    public function findAll(): array;
}
