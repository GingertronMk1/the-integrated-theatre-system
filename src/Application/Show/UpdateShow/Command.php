<?php

declare(strict_types=1);

namespace App\Application\Show\UpdateShow;

use App\Application\Season\SeasonModel;
use App\Application\Show\ShowModel;
use App\Domain\Show\ValueObject\ShowId;

final class Command
{
    public function __construct(
        public ShowId $id,
        public string $name = '',
        public ?string $description = '',
        public ?string $year = '',
        public ?string $semester = '',
        public ?SeasonModel $season = null,
    ) {
    }

    public static function forShow(ShowModel $model): self
    {
        return new self(
            $model->id,
            $model->name,
            $model->description,
            $model->year,
            $model->semester,
            $model->season
        );
    }
}
