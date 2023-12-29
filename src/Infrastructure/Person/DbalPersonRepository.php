<?php

declare(strict_types=1);

namespace App\Infrastructure\Person;

use App\Domain\Person\PersonRepositoryInterface;
use Doctrine\DBAL\Connection;

class DbalPersonRepository implements PersonRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }
}
