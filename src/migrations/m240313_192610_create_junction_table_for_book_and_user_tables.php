<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%book}}`
 * - `{{%user}}`
 */
class m240313_192610_create_junction_table_for_book_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_user}}', [
            'book_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(book_id, user_id)',
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-book_user-book_id}}',
            '{{%book_user}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-book_user-book_id}}',
            '{{%book_user}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-book_user-user_id}}',
            '{{%book_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-book_user-user_id}}',
            '{{%book_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-book_user-book_id}}',
            '{{%book_user}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-book_user-book_id}}',
            '{{%book_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-book_user-user_id}}',
            '{{%book_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-book_user-user_id}}',
            '{{%book_user}}'
        );

        $this->dropTable('{{%book_user}}');
    }
}
