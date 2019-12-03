<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%activity}}`.
 */
class m191203_120939_create_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%activities}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'start_timestamp' => $this->timestamp()->defaultExpression('now()'),
            'end_timestamp' => $this->timestamp()->defaultExpression('now()'),
            'id_author' => $this->integer(),
            'body' => $this->text(),
            'is_recurrent' => $this->boolean()->defaultValue(false),
            'is_all_day' => $this->boolean()->defaultValue(false),
        ]);
        $this->createIndex('activity_user_index', '{{%activities}}', 'id_author');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%activities}}');
    }

}
