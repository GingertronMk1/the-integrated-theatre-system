<?php

declare(strict_types=1);

namespace App\Application\Season\CreateSeason;

use App\Domain\Season\SeasonRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private SeasonRepositoryInterface $repository
    ) {
    }

    public function handle(Command $command): void
    {
    }
}
