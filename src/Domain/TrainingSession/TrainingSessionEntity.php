<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Person\ValueObject\PersonId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

class TrainingSessionEntity
{
    /**
     * @param array<TrainingItemId> $items
     * @param array<PersonId>       $trainers
     * @param array<PersonId>       $trainees
     */
    public function __construct(
        public TrainingSessionId $id,
        public DateTime $occurredAt,
        public array $items,
        public array $trainers,
        public array $trainees,
    ) {
    }
}
