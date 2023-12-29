<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Application\Person\PersonFinderInterface;
use Doctrine\DBAL\Connection;

class DbalPersonFinder implements PersonFinderInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }
}
