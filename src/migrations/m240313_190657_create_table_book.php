<?php

use yii\db\Migration;

/**
 * Class m240313_190657_create_table_book
 */
class m240313_190657_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}',[
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull()->unique(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string()->notNull(),
            'main_image' => $this->string(255),
            'ts_create' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-book-user_id', 'book', 'user_id');

        $this->addForeignKey(
            'fk-book-user_id',
            'book',
            'user_id',
            'user',
            'id',
        'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-book-user_id', 'book');
        $this->dropIndex('idx-book-user_id', 'book');

        $this->dropTable('{{%book}}');
    }
}
