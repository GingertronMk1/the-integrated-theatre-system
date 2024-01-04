<?php

declare(strict_types=1);

namespace App\Application\Season\CreateSeason;

use App\Domain\Common\ValueObject\Colour;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
        $entity = new SeasonEntity(
            $this->repository->getNextId(),
            $command->name,
            $command->description,
            Colour::fromString($command->colour)
        );
        $this->repository->save($entity);
    }
}
