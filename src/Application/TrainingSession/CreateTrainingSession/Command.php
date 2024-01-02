<?php

declare(strict_types=1);

namespace App\Application\TrainingSession\CreateTrainingSession;

use App\Application\Person\PersonModel;
use App\Application\TrainingItem\TrainingItemModel;
use App\Domain\Common\ValueObject\DateTime;

class Command
{
    /**
     * @param array<TrainingItemModel> $items
     * @param array<PersonModel>       $trainers
     * @param array<PersonModel>       $trainees
     */
    public function __construct(
        public ?DateTime $occurredAt = null,
        public array $items = [],
        public array $trainers = [],
        public array $trainees = [],
    ) {
    }
}
