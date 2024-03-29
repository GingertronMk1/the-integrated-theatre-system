<?php

declare(strict_types=1);

namespace App\Application\TrainingSession\UpdateTrainingSession;

use App\Application\Person\PersonModel;
use App\Application\TrainingItem\TrainingItemModel;
use App\Application\TrainingSession\TrainingSessionModel;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use DateTimeInterface;

class Command
{
    /**
     * @param array<TrainingItemModel> $items
     * @param array<PersonModel>       $trainers
     * @param array<PersonModel>       $trainees
     */
    public function __construct(
        public TrainingSessionId $id,
        public ?DateTimeInterface $occurredAt = null,
        public array $items = [],
        public array $trainers = [],
        public array $trainees = [],
    ) {
    }

    public static function forSession(TrainingSessionModel $session): self
    {
        return new self(
            $session->id,
            $session->occurredAt->toDateTimeImmutable(),
            $session->items,
            $session->trainers,
            $session->trainees,
        );
    }
}
