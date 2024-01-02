<?php

declare(strict_types=1);

namespace App\Application\Season;

use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Season\ValueObject\SeasonId;

final readonly class SeasonModel
{
    public function __construct(
        public SeasonId $id,
        public string $name,
        public ?string $description,
        public string $colour,
        public DateTime $createdAt,
        public Datetime $updatedAt,
        public ?DateTime $deletedAt,
    ) {
    }
}
