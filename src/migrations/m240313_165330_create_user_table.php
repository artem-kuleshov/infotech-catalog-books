<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240313_165330_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255)->notNull()->unique(),
            'password' => $this->string(255),
            'phone' => $this->bigInteger(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'patronymic' => $this->string(255),
            'auth_key' => $this->string(255),
            'ts_create' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}