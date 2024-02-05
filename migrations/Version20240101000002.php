<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000002 extends AbstractMigration
{
    private const PEOPLE_TABLE = 'people';

    public function getDescription(): string
    {
        return 'People';
    }

    public function up(Schema $schema): void
    {
        $peopleTable = $this->makeTable($schema, self::PEOPLE_TABLE);
        $peopleTable->addColumn('name', Types::STRING);
        $peopleTable->addColumn('bio', Types::TEXT, ['notnull' => false]);
        $peopleTable->addColumn('start_year', Types::STRING, ['notnull' => false]);
        $peopleTable->addColumn('end_year', Types::STRING, ['notnull' => false]);
        $peopleTable->addColumn('user_id', Types::GUID, ['notnull' => false]);
        $peopleTable->addIndex(['start_year']);
        $peopleTable->addIndex(['end_year']);
        $peopleTable->addForeignKeyConstraint(
            'users',
            ['user_id'],
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
            ->dropTable(self::PEOPLE_TABLE)
        ;
    }
}
