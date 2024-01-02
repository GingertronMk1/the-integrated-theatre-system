<?php

declare(strict_types=1);

namespace App\Application\Show\CreateShow;

use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private ShowRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $entity = new ShowEntity(
            $this->repository->getNextId(),
            $command->name,
            $command->description,
            $command->year,
            $command->semester,
            $command->season
        );

        $this->repository->createShow($entity);
    }
}
