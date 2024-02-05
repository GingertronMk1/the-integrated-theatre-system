<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000001 extends AbstractMigration
{
    private const TRAINING_CATEGORIES_TABLE = 'training_categories';
    private const TRAINING_ITEMS_TABLE = 'training_items';

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
                'update' => 'CASCADE',
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
}
