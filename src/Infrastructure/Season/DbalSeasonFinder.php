<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Season\SeasonFinderInterface;
use Doctrine\DBAL\Connection;

final readonly class DbalSeasonFinder implements SeasonFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }
}
