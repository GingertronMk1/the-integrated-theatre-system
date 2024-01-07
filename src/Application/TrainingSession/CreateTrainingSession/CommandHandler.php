<?php

declare(strict_types=1);

namespace App\Application\TrainingSession\CreateTrainingSession;

use App\Application\Person\PersonModel;
use App\Application\TrainingItem\TrainingItemModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingSession\TrainingSessionEntity;
use App\Domain\TrainingSession\TrainingSessionRepositoryInterface;
use App\Domain\TrainingSession\ValueObject\TrainingSessionId;

final readonly class CommandHandler
{
    public function __construct(
        private TrainingSessionRepositoryInterface $trainingSessionRepository
    ) {
    }

    public function handle(Command $command): TrainingSessionId
    {
        $id = $this->trainingSessionRepository->getNextId();
        $entity = new TrainingSessionEntity(
            $id,
            DateTime::fromDateTimeInterface($command->occurredAt),
            array_map(fn (TrainingItemModel $item) => $item->id, $command->items),
            array_map(fn (PersonModel $person) => $person->id, $command->trainers),
            array_map(fn (PersonModel $person) => $person->id, $command->trainees),
        );
        $this->trainingSessionRepository->save($entity);

        return $id;
    }
}
