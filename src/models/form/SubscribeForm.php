<?php

namespace app\models\form;

use app\models\base\Subscription;
use app\models\User;
use yii\base\Model;


class SubscribeForm extends Model
{
    public $phone;
    public $author_id;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            ['phone', 'required'],
            ['phone', 'integer'],
            ['phone', 'match', 'pattern' => '/^(8|7)(\d{10})$/'],
            ['author_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id'],
            [['phone'], 'unique', 'targetClass' => Subscription::class, 'targetAttribute' => ['phone', 'author_id']],
        ];
    }

    public function subscribe(): bool
    {
        $model = new Subscription();
        $model->phone = $this->phone;
        $model->author_id = $this->author_id;
        return $model->save(false);
    }
}