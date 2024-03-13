<?php

use yii\db\Migration;

/**
 * Class m240313_192743_create_table_subscription
 */
class m240313_192743_create_table_subscription extends Migration
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
        echo "m240313_192743_create_table_subscription cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240313_192743_create_table_subscription cannot be reverted.\n";

        return false;
    }
    */
}
