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
        return 'Creating the users table';
    }

    public function up(Schema $schema): void
    {
        $usersTable = $this->makeTable($schema, self::USERS_TABLE);
        $usersTable->addColumn('email', Types::STRING, ['notnull' => false]);
        $usersTable->addColumn('password', Types::STRING, ['notnull' => false]);
        $usersTable->addIndex(['email']);
    }

    public function down(Schema $schema): void
    {
        $schema
            ->dropTable(self::USERS_TABLE)
        ;
    }
}
