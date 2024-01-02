<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Season\SeasonRepositoryInterface;
use Doctrine\DBAL\Connection;

final readonly class DbalSeasonRepository implements SeasonRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private ClockInterface $clock
    ) {
    }
}
