<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000003 extends AbstractMigration
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
        $sessionsTable = $this->makeTable($schema, self::TRAINING_SESSIONS_TABLE);
        $sessionsTable->addColumn('occurred_at', Types::STRING);
        $sessionsTable->addIndex(['occurred_at']);

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
                'update' => 'CASCADE',
            ]
        );
        $sessionItemsPivotTable->addForeignKeyConstraint(
            $schema->getTable('training_items'),
            ['training_item_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );

        $sessionPeoplePivotTable = $schema->createTable(self::TRAINING_SESSION_PEOPLE_TABLE);
        $sessionPeoplePivotTable->addColumn('training_session_id', Types::GUID);
        $sessionPeoplePivotTable->addColumn('person_id', Types::GUID);
        $sessionPeoplePivotTable->addColumn('type', Types::STRING);
        $sessionPeoplePivotTable->setPrimaryKey(['training_session_id', 'person_id']);
        $sessionPeoplePivotTable->addIndex(['type']);
        $sessionPeoplePivotTable->addForeignKeyConstraint(
            $sessionsTable,
            ['training_session_id'],
            ['id'],
            [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ]
        );
        $sessionPeoplePivotTable->addForeignKeyConstraint(
            $schema->getTable('people'),
            ['person_id'],
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
            ->dropTable(self::TRAINING_SESSIONS_TABLE)
            ->dropTable(self::TRAINING_SESSION_ITEMS_TABLE)
            ->dropTable(self::TRAINING_SESSION_PEOPLE_TABLE)
        ;
    }
}
