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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191203_124253_create_fk_activities_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191203_124253_create_fk_activities_users cannot be reverted.\n";

        return false;
    }
    */
}
