<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000005 extends AbstractMigration
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
                'update' => 'CASCADE',
            ]
        );
        $crewMembersTable->addForeignKeyConstraint(
            $schema->getTable('people'),
            ['person_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );
        $crewMembersTable->addForeignKeyConstraint(
            $schema->getTable('shows'),
            ['show_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );

        $castMembersTable = $this->makeTable($schema, self::CAST_MEMBERS_TABLE);
        $castMembersTable->addColumn('role', Types::STRING);
        $castMembersTable->addColumn('notes', Types::TEXT);
        $castMembersTable->addColumn('show_id', Types::GUID);
        $castMembersTable->addColumn('person_id', Types::GUID);
        $castMembersTable->addColumn('credit_order', Types::INTEGER);
        $castMembersTable->addIndex(['credit_order']);
        $castMembersTable->addForeignKeyConstraint(
            $schema->getTable('people'),
            ['person_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );
        $castMembersTable->addForeignKeyConstraint(
            $schema->getTable('shows'),
            ['show_id'],
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
            ->dropTable(self::ROLES_TABLE)
            ->dropTable(self::CREW_MEMBERS_TABLE)
            ->dropTable(self::CAST_MEMBERS_TABLE)
        ;
    }
}
