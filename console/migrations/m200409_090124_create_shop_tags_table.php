<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_tags}}`.
 */
class m200409_090124_create_shop_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shop_tags}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_tags}}');
    }
}
