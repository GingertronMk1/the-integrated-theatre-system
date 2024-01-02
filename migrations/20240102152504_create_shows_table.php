<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateShowsTable extends AbstractMigration
{
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
        $table = $this->table('shows', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('description', 'string')
            ->addColumn('year', 'string')
            ->addColumn('semester', 'string')
            ->addColumn('season', 'string')
            ->addColumn('created_at', 'string')
            ->addColumn('updated_at', 'string')
            ->addColumn('deleted_at', 'string')
            ->create()
        ;
        $table
            ->addIndex('name')
            ->addIndex('year')
            ->addIndex('semester')
            ->addIndex('season')
            ->addIndex('deleted_at')
            ->update();
    }
}
