<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000004 extends AbstractMigration
{
    private const SHOWS_TABLE = 'shows';
    private const SEASONS_TABLE = 'seasons';

    public function getDescription(): string
    {
        return 'Shows and seasons';
    }

    public function up(Schema $schema): void
    {
        $seasonsTable = $this->makeTable($schema, self::SEASONS_TABLE);
        $seasonsTable->addColumn('name', Types::STRING);
        $seasonsTable->addColumn('description', Types::TEXT, ['notnull' => false]);
        $seasonsTable->addColumn('colour', Types::STRING);
        $seasonsTable->addIndex(['name']);

        $showsTable = $this->makeTable($schema, self::SHOWS_TABLE);
        $showsTable->addColumn('name', Types::STRING);
        $showsTable->addColumn('description', Types::TEXT, ['notnull' => false]);
        $showsTable->addColumn('year', Types::STRING, ['notnull' => false]);
        $showsTable->addColumn('season_id', Types::GUID, ['notnull' => false]);
        $showsTable->addIndex(['name']);
        $showsTable->addIndex(['year']);
        $showsTable->addForeignKeyConstraint(
            $seasonsTable,
            ['season_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );
    }

    public function down(Schema $schema): void
    {
        $schema
            ->dropTable(self::SHOWS_TABLE)
            ->dropTable(self::SEASONS_TABLE)
        ;
    }
}
