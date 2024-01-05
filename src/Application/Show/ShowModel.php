<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Application\Season\SeasonModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Show\ValueObject\ShowId;

final readonly class ShowModel
{
    public function __construct(
        public ShowId $id,
        public string $name,
        public ?string $description,
        public ?string $year,
        public ?SeasonModel $season,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt,
    ) {
    }
}
