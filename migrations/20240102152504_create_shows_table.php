<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateShowsTable extends AbstractMigration
{
    private const SHOWS_TABLE = 'shows';
    private const SEASONS_TABLE = 'seasons';
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $seasonsTable = $this->table(self::SEASONS_TABLE, ['id' => false, 'primary_key' => 'id']);
        $seasonsTable
            ->addColumn('id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text')
            ->addColumn('colour', 'string')
            ->addColumn('created_at', 'string')
            ->addColumn('updated_at', 'string')
            ->addColumn('deleted_at', 'string')
            ->create();
        $seasonsTable
            ->addIndex('name')
            ->addIndex('deleted_at')
            ->update();
        $showsTable = $this->table(self::SHOWS_TABLE, ['id' => false, 'primary_key' => 'id']);
        $showsTable
            ->addColumn('id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text')
            ->addColumn('year', 'string')
            ->addColumn('semester', 'string')
            ->addColumn('season_id', 'string')
            ->addColumn('created_at', 'string')
            ->addColumn('updated_at', 'string')
            ->addColumn('deleted_at', 'string')
            ->create();
        $showsTable
            ->addIndex('name')
            ->addIndex('year')
            ->addIndex('semester')
            ->addForeignKey(
                'season_id',
                self::SEASONS_TABLE,
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ]
            )
            ->addIndex('deleted_at')
            ->update();

    }
}
