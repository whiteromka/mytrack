<?php

use yii\db\Migration;

/**
 * Class m220311_173737_create_base_tables
 */
class m220311_173737_create_base_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%group}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string(),
            'status' => $this->tinyInteger()->comment('0 No active, 1 Active'),
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'gender' => $this->tinyInteger()->comment('0 Female, 1 Male'),
            'status' => $this->tinyInteger()->comment('0 No active, 1 Active'),
            'birthday' => $this->date(),
            'auth_key' => $this->string(),
            'access_token' => $this->string(),
            'password_hash' => $this->string(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->createTable('{{%user_group}}', [
            'user_id' => $this->integer()->notNull(),
            'group_id' => $this->integer()->notNull(),
        ]);
        $this->addPrimaryKey('pk_user_group', 'user_group', ['user_id', 'group_id']);
        $this->addForeignKey(
            'fk_user_group__user_id',
            'user_group',
            'user_id',
            'user',
            'id',
            'cascade'
        );
        $this->addForeignKey(
            'fk_user_group__group_id',
            'user_group',
            'group_id',
            'group',
            'id',
            'cascade'
        );

        $this->createTable('{{%space}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->tinyInteger()->comment('0 No active, 1 Active'),
            'owner_id' => $this->integer(),
            'created_at' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            'updated_at' => 'TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP()',
        ]);

        $this->createIndex('idx_space_owner_id', 'space', 'owner_id');
      //  $this->createIndex('idx_user_group_id', 'user', 'group_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_group');
        $this->dropTable('space');
        $this->dropTable('user');
        $this->dropTable('group');

    }
}
