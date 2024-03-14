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
        $this->createTable('{{%subscription}}',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Авторизованный пользователь тоже может подписаться на авторов"),
            'phone' => $this->string(255)->notNull(),
            'author_id' => $this->integer()->notNull(),
            'ts_create' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-subscription-author_id', 'subscription', 'author_id');

        $this->addForeignKey(
            'fk-subscription-author_id',
            'subscription',
            'author_id',
            'user',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscription-author_id', 'subscription');
        $this->dropIndex('idx-subscription-author_id', 'subscription');

        $this->dropTable('{{%subscription}}');
    }
}
