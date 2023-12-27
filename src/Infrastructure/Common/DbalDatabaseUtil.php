<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use App\Domain\Common\DatabaseUtilInterface;
use Doctrine\DBAL\Connection;

final readonly class DbalDatabaseUtil implements DatabaseUtilInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function truncateAllTables(): void
    {
        $schemaManager = $this->connection->createSchemaManager();

        foreach ($schemaManager->listTableNames() as $table) {
            if ('phinxlog' !== $table) {
                $qb = $this->connection->createQueryBuilder();
                $qb->delete($table)->executeQuery();
            }
        }
    }
}
