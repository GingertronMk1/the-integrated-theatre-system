<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\Show\ShowFinderInterface;
use Doctrine\DBAL\Connection;

final readonly class DbalShowFinder implements ShowFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }
}
