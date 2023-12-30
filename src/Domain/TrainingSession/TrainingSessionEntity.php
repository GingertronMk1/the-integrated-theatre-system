<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeImmutable;

class TrainingSessionEntity
{
    public function __construct(
        public TrainingSessionId $id,
        public DateTimeImmutable $occurredAt,
        public array $items,
        public array $trainers,
        public array $trainees,
    ) {
    }
}
