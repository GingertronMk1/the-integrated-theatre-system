<?php

declare(strict_types=1);

namespace App\Application\Season\UpdateSeason;

use App\Application\Season\SeasonModel;
use App\Domain\Season\ValueObject\SeasonId;

final class Command
{
    public function __construct(
        public SeasonId $id,
    ) {
    }

    public static function forSeason(SeasonModel $command): self
    {
        return new self(
            $command->id,
        );
    }
}
