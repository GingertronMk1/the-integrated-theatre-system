<?php

declare(strict_types=1);

namespace App\Application\Season\UpdateSeason;

use App\Domain\Common\ValueObject\Colour;
use App\Domain\Season\SeasonEntity;
use App\Domain\Season\SeasonRepositoryInterface;
use App\Domain\Season\ValueObject\SeasonId;

final readonly class CommandHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): SeasonId
    {
        $entity = new SeasonEntity(
            $command->id,
            $command->name,
            $command->description,
            Colour::fromString($command->colour)
        );
        $this->repository->save($entity);

        return $command->id;
    }
}
