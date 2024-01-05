<?php

declare(strict_types=1);

namespace App\Application\CastMember\CreateCastMember;

use App\Application\Person\PersonModel;
use App\Application\Show\ShowModel;
use App\Domain\Show\ValueObject\ShowId;

final class Command
{
    public function __construct(
        public ?ShowId $showId = null,
        public string $role = '',
        public ?PersonModel $person = null,
    ) {
    }

    public static function forShow(ShowModel $show): self
    {
        return new self(
            $show->id,
        );
    }
}
