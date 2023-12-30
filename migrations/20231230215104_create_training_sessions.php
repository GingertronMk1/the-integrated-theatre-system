<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTrainingSessions extends AbstractMigration
{
    private const SESSIONS_TABLE = 'training_sessions';

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
        $sessionsTable = $this->table(self::SESSIONS_TABLE, ['id' => false, 'primary_key' => 'id']);
        $sessionsTable
          ->addColumn('id', 'string')
          ->addColumn('occurred_at', 'string')
          ->addColumn('created_at', 'string')
          ->addColumn('updated_at', 'string')
          ->addColumn('deleted_at', 'string')
          ->create();

        $sessionsTable
          ->addIndex('occurred_at')
          ->addIndex('deleted_at')
          ->update();

        $itemsPivotTable = $this->table('training_session_items', ['id' => false, 'primary_key' => ['training_session_id', 'training_item_id']]);
        $itemsPivotTable
          ->addColumn('training_session_id', 'string')
          ->addColumn('training_item_id', 'string')
          ->create();

        $itemsPivotTable
          ->addForeignKey(
              'training_session_id',
              self::SESSIONS_TABLE,
              'id',
              [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
              ]
          )
          ->addForeignKey(
              'training_item_id',
              'training_items',
              'id',
              [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
              ]
          )
          ->update();

        $peoplePivotTable = $this->table('training_session_people', ['id' => false, 'primary_key' => ['training_session_id', 'person_id']]);
        $peoplePivotTable
          ->addColumn('training_session_id', 'string')
          ->addColumn('person_id', 'string')
          ->addColumn('type', 'string')
          ->create();

        $peoplePivotTable
          ->addIndex('type')
          ->addForeignKey(
              'training_session_id',
              self::SESSIONS_TABLE,
              'id',
              [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
              ]
          )
          ->addForeignKey(
              'person_id',
              'people',
              'id',
              [
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
              ]
          )
          ->update();
    }
}
