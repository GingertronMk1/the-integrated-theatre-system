<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

interface TrainingSessionRepositoryInterface
{
    public function getNextId(): TrainingSessionId;

    public function saveSession(TrainingSessionEntity $session): void;
}
