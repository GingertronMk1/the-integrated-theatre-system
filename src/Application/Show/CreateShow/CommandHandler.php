<?php

declare(strict_types=1);

namespace App\Application\Show\CreateShow;

use App\Domain\Show\ShowEntity;
use App\Domain\Show\ShowRepositoryInterface;
use App\Domain\Show\ValueObject\ShowId;

final readonly class CommandHandler
{
    public function __construct(
        private ShowRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): ShowId
    {
        $id = $this->repository->getNextId();
        $entity = new ShowEntity(
            $id,
            $command->name,
            $command->description,
            $command->year,
            $command->season?->id ?? null
        );

        $this->repository->save($entity);

        return $id;
    }
}
