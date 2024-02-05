<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Framework\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101000000 extends AbstractMigration
{
    private const USERS_TABLE = 'users';

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
