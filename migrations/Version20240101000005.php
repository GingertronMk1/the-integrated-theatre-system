<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use App\Framework\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240203192444 extends AbstractMigration
{
    private const ROLES_TABLE = 'crew_roles';
    private const CREW_MEMBERS_TABLE = 'crew_members';
    private const CAST_MEMBERS_TABLE = 'cast_members';

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $rolesTable = $this->makeTable($schema, self::ROLES_TABLE);
        $rolesTable->addColumn('name', Types::STRING);
        $rolesTable->addColumn('description', Types::TEXT);

        $crewMembersTable = $this->makeTable($schema, self::CREW_MEMBERS_TABLE);
        $crewMembersTable->addColumn('role_id', Types::GUID);
        $crewMembersTable->addColumn('notes', Types::TEXT);
        $crewMembersTable->addColumn('show_id', Types::GUID);
        $crewMembersTable->addColumn('person_id', Types::GUID);
        $crewMembersTable->addColumn('credit_order', Types::INTEGER);
        $crewMembersTable->addIndex(['credit_order']);
        $crewMembersTable->addForeignKeyConstraint(
            $rolesTable,
            ['role_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $crewMembersTable->addForeignKeyConstraint(
            $schema->getTable('people'),
            ['person_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $crewMembersTable->addForeignKeyConstraint(
            $schema->getTable('shows'),
            ['show_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );

        $castMembersTable = $this->makeTable($schema, self::CAST_MEMBERS_TABLE);
        $castMembersTable->addColumn('role', Types::STRING);
        $castMembersTable->addColumn('notes', Types::TEXT);
        $castMembersTable->addColumn('show_id', Types::GUID);
        $castMembersTable->addColumn('person_id', Types::GUID);
        $castMembersTable->addForeignKeyConstraint(
            $schema->getTable('people'),
            ['person_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $castMembersTable->addForeignKeyConstraint(
            $schema->getTable('shows'),
            ['show_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );

    }

    public function down(Schema $schema): void
    {
        $schema
            ->dropTable(self::PEOPLE_TABLE)
            ->dropTable(self::TRAINING_ITEMS_TABLE)
            ->dropTable(self::TRAINING_CATEGORIES_TABLE)
            ->dropTable(self::USERS_TABLE)
            ->dropTable(self::TRAINING_SESSIONS_TABLE)
            ->dropTable(self::TRAINING_SESSION_ITEMS_TABLE)
            ->dropTable(self::TRAINING_SESSION_PEOPLE_TABLE)
        ;
    }

    /**
     * Make a table with ID and timestamp fields, appropriately indexed
     */
    private function makeTable(Schema $schema, string $tableName): Table
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
