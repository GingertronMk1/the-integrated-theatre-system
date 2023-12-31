<?php

declare(strict_types=1);

namespace App\Application\TrainingSession\UpdateTrainingSession;

use App\Application\Person\PersonModel;
use App\Application\TrainingItem\TrainingItemModel;
use App\Application\TrainingSession\TrainingSessionModel;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeImmutable;

class Command
{
    /**
     * @param array<TrainingItemModel> $items
     * @param array<PersonModel>       $trainers
     * @param array<PersonModel>       $trainees
     */
    public function __construct(
        public TrainingSessionId $id,
        public DateTimeImmutable $occurredAt = new DateTimeImmutable(),
        public array $items = [],
        public array $trainers = [],
        public array $trainees = [],
    ) {
    }

    public static function forSession(TrainingSessionModel $session): self
    {
        return new self(
            $session->id,
            $session->occurredAt,
            $session->items,
            $session->trainers,
            $session->trainees,
        );
    }
}
