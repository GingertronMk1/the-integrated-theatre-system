<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class MakeShowTables extends AbstractMigration
{
    private const ROLES_TABLE = 'crew_roles';
    private const CREW_MEMBERS_TABLE = 'crew_members';
    private const CAST_MEMBERS_TABLE = 'cast_members';

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
        $crewRoles = $this->table(
            self::ROLES_TABLE,
            [
                'id' => false,
                'primary_key' => 'id',
            ]
        );
        $crewRoles
            ->addColumn('id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text')
            ->addColumn('created_at', 'string')
            ->addColumn('updated_at', 'string')
            ->addColumn('deleted_at', 'string')
            ->create();
        $crewRoles
            ->addIndex('deleted_at')
            ->update();

        $crewMembers = $this->table(
            self::CREW_MEMBERS_TABLE,
            [
                'id' => false,
                'primary_key' => 'id',
            ]
        );
        $crewMembers
            ->addColumn('id', 'string')
            ->addColumn('role_id', 'string')
            ->addColumn('notes', 'text')
            ->addColumn('show_id', 'string')
            ->addColumn('person_id', 'string')
            ->addColumn('credit_order', 'integer')
            ->create();
        $crewMembers
            ->addIndex('credit_order')
            ->addForeignKey(
                'show_id',
                'shows',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ])
            ->addForeignKey(
                'person_id',
                'people',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ])
            ->addForeignKey('role_id',
                self::ROLES_TABLE,
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ])
            ->update();

        $castMembers = $this->table(
            self::CAST_MEMBERS_TABLE,
            [
                'id' => false,
                'primary_key' => 'id',
            ]
        );

        $castMembers
            ->addColumn('id', 'string')
            ->addColumn('role', 'string')
            ->addColumn('notes', 'text')
            ->addColumn('show_id', 'string')
            ->addColumn('person_id', 'string')
            ->addColumn('credit_order', 'integer')
            ->create();
        $castMembers
            ->addIndex('credit_order')
            ->addForeignKey(
                'show_id',
                'shows',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ])
            ->addForeignKey(
                'person_id',
                'people',
                'id',
                [
                    'delete' => 'CASCADE',
                    'update' => 'CASCADE',
                ])
            ->update();
    }
}
