<?php

namespace app\models\base;


use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'book';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('book_user', ['book_id' => 'id']);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function saveSoAuthors(array $so_authors = [])
    {
        Yii::$app->db->createCommand("DELETE FROM book_user WHERE book_id = :book_id", [':book_id' => $this->id])->execute();

        if ($so_authors) {
            $data = [];
            foreach ($so_authors as $author_id) {
                $data[] = [$this->id, $author_id];
            }
            \Yii::$app->db->createCommand()->batchInsert("book_user", ['book_id', 'user_id'], $data)->execute();
        }
    }
}