<?php

declare(strict_types=1);

namespace App\Framework\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration as DoctrineAbstractMigration;

abstract class AbstractMigration extends DoctrineAbstractMigration
{
    /**
     * Make a table with ID and timestamp fields, appropriately indexed.
     */
    protected function makeTable(Schema $schema, string $tableName): Table
    {
        $table = $schema->createTable($tableName);
        $table->addColumn('id', Types::GUID, ['notnull' => true]);
        $table->addColumn('created_at', Types::STRING, ['notnull' => false]);
        $table->addColumn('updated_at', Types::STRING, ['notnull' => false]);
        $table->addColumn('deleted_at', Types::STRING, ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['created_at']);
        $table->addIndex(['updated_at']);
        $table->addIndex(['deleted_at']);

        return $table;
    }
}
