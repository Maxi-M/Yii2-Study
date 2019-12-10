<?php

use yii\db\Migration;

/**
 * Class m191209_095944_add_fields_to_activities_table
 */
class m191209_095944_add_fields_to_activities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%activities}}', 'created_at', 'timestamp');
        $this->addColumn('{{%activities}}', 'updated_at', 'timestamp');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%activities}}', 'created_at');
        $this->dropColumn('{{%activities}}', 'updated_at');

        return true;
    }
}
