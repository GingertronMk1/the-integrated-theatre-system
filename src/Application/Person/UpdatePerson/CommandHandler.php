<?php

declare(strict_types=1);

namespace App\Application\Person\UpdatePerson;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $personRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $personEntity = new PersonEntity(
            $command->id,
            $command->name,
            $command->bio,
            $command->startYear,
            $command->endYear,
            $command->user?->id ?? null
        );
        $this->personRepository->save($personEntity);
    }
}
