<?php

declare(strict_types=1);

namespace App\Application\Show\UpdateShow;

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
            $command->id,
            $command->name,
            $command->description,
            $command->year,
            $command->semester,
            $command->season?->id ?? null
        );

        $this->repository->updateShow($entity);
    }
}
