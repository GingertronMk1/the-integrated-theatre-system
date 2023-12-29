<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePeopleTable extends AbstractMigration
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
     * Table people {
  id string [primary key]
  user_id string [null, ref: - users.id]
  name string [null]
  start_year string
  end_year string
  created_at timestamp
  updated_at timestamp
}

     */
    public function change(): void
    {
        $table = $this->table('people', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'string')
            ->addColumn('user_id', 'string', ['null' => true])
            ->addColumn('name', 'string')
            ->addColumn('start_year', 'string')
            ->addColumn('end_year', 'string')
            ->addColumn('created_at', 'string')
            ->addColumn('updated_at', 'string')
            ->addColumn('deleted_at', 'string')
            ->create()
        ;

        $table
            ->addIndex('start_year')
            ->addIndex('end_year')
            ->addIndex('deleted_at')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE'
                ]
            )
            ->update()
            ;
    }
}
