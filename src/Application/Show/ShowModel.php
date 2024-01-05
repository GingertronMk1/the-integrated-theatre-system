<?php

declare(strict_types=1);

namespace App\Application\Show;

use App\Application\CastMember\CastMemberModel;
use App\Application\CrewMember\CrewMemberModel;
use App\Application\Season\SeasonModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Show\ValueObject\ShowId;

final readonly class ShowModel
{
    /**
     * @param array<CastMemberModel> $castMembers
     * @param array<CrewMemberModel> $crewMembers
     */
    public function __construct(
        public ShowId $id,
        public string $name,
        public ?string $description,
        public ?string $year,
        public ?SeasonModel $season,
        public array $castMembers,
        public array $crewMembers,
        public DateTime $createdAt,
        public DateTime $updatedAt,
        public ?DateTime $deletedAt,
    ) {
    }
}
