<?php

use yii\db\Migration;

/**
 * Class m191203_124253_create_fk_activities_users
 */
class m191203_124253_create_fk_activities_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_activities_users','{{%activities}}', 'id_author', '{{%users}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_activities_users','{{%activities}}');
        return true;
    }
}
