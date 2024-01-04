<?php

declare(strict_types=1);

namespace App\Application\Person\CreatePerson;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;

class CommandHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $personRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $personEntity = new PersonEntity(
            $this->personRepository->getNextId(),
            $command->name,
            $command->bio,
            $command->startYear,
            $command->endYear,
            $command->user?->id ?? null
        );
        $this->personRepository->save($personEntity);
    }
}
