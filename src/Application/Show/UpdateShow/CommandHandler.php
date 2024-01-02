<?php

declare(strict_types=1);

namespace App\Application\Show\UpdateShow;

use App\Domain\Show\ShowRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private ShowRepositoryInterface $ShowRepository
    ) {
    }

    public function handle(Command $command): void
    {
    }
}
