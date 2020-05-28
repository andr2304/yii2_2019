<?php

use yii\db\Migration;

/**
 * Class m200407_112850_rename_users_table
 */
class m200407_112850_rename_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%user}}', '{{%users}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200407_112850_rename_users_table cannot be reverted.\n";

        return false;
    }
    */
}
