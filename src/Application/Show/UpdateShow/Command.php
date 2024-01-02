<?php

declare(strict_types=1);

namespace App\Application\Show\UpdateShow;

use App\Domain\Show\ValueObject\ShowId;

final class Command
{
    public function __construct(
        public ShowId $id,
    ) {
    }

    public static function forShow(Command $command): self
    {
        return new self(
            $command->id,
        );
    }
}
