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
    private const TRAINING_SESSIONS_TABLE = 'training_sessions';
    private const TRAINING_SESSION_ITEMS_TABLE = 'training_session_items';
    private const TRAINING_SESSION_PEOPLE_TABLE = 'training_session_people';

    public function getDescription(): string
    {
        return 'Training sessions';
    }

    public function up(Schema $schema): void
    {
        $sessionsTable = $schema->getTable('training_sessions');
        $trainingItemsTable = $schema->getTable('training_items');
        $peopleTable = $schema->getTable('people');

        $sessionsTable = $this->makeTable($schema, self::TRAINING_SESSIONS_TABLE);
        $sessionsTable->addColumn('occurred_at', Types::STRING);
        $sessionsTable->addIndex(['occurredAt']);

        $sessionItemsPivotTable = $schema->createTable(self::TRAINING_SESSION_ITEMS_TABLE);
        $sessionItemsPivotTable->addColumn('training_session_id', Types::GUID);
        $sessionItemsPivotTable->addColumn('training_item_id', Types::GUID);
        $sessionItemsPivotTable->setPrimaryKey(['training_session_id', 'training_item_id']);
        $sessionItemsPivotTable->addForeignKeyConstraint(
            $sessionsTable,
            ['training_session_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $sessionItemsPivotTable->addForeignKeyConstraint(
            $trainingItemsTable,
            ['training_item_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );

        $sessionPeoplePivotTable = $schema->createTable(self::TRAINING_SESSION_PEOPLE_TABLE);
        $sessionPeoplePivotTable->addColumn('training_session_id', Types::GUID);
        $sessionPeoplePivotTable->addColumn('person_id', Types::GUID);
        $sessionPeoplePivotTable->setPrimaryKey(['training_session_id', 'person_id']);
        $sessionPeoplePivotTable->addForeignKeyConstraint(
            $sessionsTable,
            ['training_session_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE'
            ]
        );
        $sessionPeoplePivotTable->addForeignKeyConstraint(
            $peopleTable,
            ['person_id'],
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
