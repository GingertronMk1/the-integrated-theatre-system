<?php

declare(strict_types=1);

namespace App\Application\Person\UpdatePerson;

use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonRepositoryInterface;
use App\Domain\Person\ValueObject\PersonId;

final readonly class CommandHandler
{
    public function __construct(
        private readonly PersonRepositoryInterface $personRepository
    ) {
    }

    public function handle(Command $command): PersonId
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

        return $command->id;
    }
}
