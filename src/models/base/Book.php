<?php

namespace app\models\base;


use app\models\User;
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
}