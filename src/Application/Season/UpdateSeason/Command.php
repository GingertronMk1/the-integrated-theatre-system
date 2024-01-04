<?php

declare(strict_types=1);

namespace App\Application\Season\UpdateSeason;

use App\Application\Season\SeasonModel;
use App\Domain\Season\ValueObject\SeasonId;

final class Command
{
    public function __construct(
        public SeasonId $id,
        public string $name = '',
        public ?string $description = '',
        public string $colour = '',
    ) {
    }

    public static function forSeason(SeasonModel $model): self
    {
        return new self(
            $model->id,
            $model->name,
            $model->description,
            (string) $model->colour
        );
    }
}
