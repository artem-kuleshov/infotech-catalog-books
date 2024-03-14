<?php

namespace app\models\base;


use app\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Subscription extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'subscription';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}