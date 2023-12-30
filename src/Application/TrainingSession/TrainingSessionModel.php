<?php

declare(strict_types=1);

namespace App\Application\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeImmutable;

final readonly class TrainingSessionModel
{
    public function __construct(
        public TrainingSessionId $id,
        public DateTimeImmutable $occurredAt,
        public array $items,
        public array $trainers,
        public array $trainees,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt,
    ) {
    }
}
