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
    private const USERS_TABLE = 'users';
    private const TRAINING_CATEGORIES_TABLE = 'training_categories';
    private const TRAINING_ITEMS_TABLE = 'training_items';
    private const PEOPLE_TABLE = 'people';
    private const TRAINING_SESSIONS_TABLE = 'training_sessions';
    private const TRAINING_SESSION_ITEMS_TABLE = 'training_session_items';
    private const TRAINING_SESSION_PEOPLE_TABLE = 'training_session_people';
    private const SHOWS_TABLE = 'shows';
    private const SEASONS_TABLE = 'seasons';

    public function getDescription(): string
    {
        return 'Training categories and items';
    }

    public function up(Schema $schema): void
    {
        $trainingCategoriesTable = $this->makeTable($schema, self::TRAINING_CATEGORIES_TABLE);
        $trainingCategoriesTable->addColumn('name', Types::STRING);
        $trainingCategoriesTable->addIndex(['name']);

        $trainingItemsTable = $this->makeTable($schema, self::TRAINING_ITEMS_TABLE);
        $trainingItemsTable->addColumn('name', Types::STRING);
        $trainingItemsTable->addColumn('is_dangerous', Types::BOOLEAN);
        $trainingItemsTable->addColumn('training_category_id', Types::GUID);
        $trainingItemsTable->addIndex(['name']);
        $trainingItemsTable->addForeignKeyConstraint(
            $trainingCategoriesTable,
            ['training_category_id'],
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
            ->dropTable(self::TRAINING_ITEMS_TABLE)
            ->dropTable(self::TRAINING_CATEGORIES_TABLE)
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
