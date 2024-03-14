<?php

namespace app\models\form;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegistrationForm extends Model
{
    public $login;
    public $password;
    public $phone;
    public $first_name;
    public $last_name;
    public $patronymic;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['login', 'phone',  'password', 'first_name'], 'required'],
            [['login', 'password', 'first_name', 'last_name', 'patronymic'], 'trim'],
            ['phone', 'integer'],
            ['login', 'unique', 'targetClass' => User::class],
            ['phone', 'unique', 'targetClass' => User::class],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\Exception
     */
    public function register(): bool
    {
        if ($this->validate()) {
            $user = new User();
            $user->login = $this->login;
            $user->phone = $this->phone;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->patronymic = $this->patronymic;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            return $user->save(false);
        }
        return false;
    }
}
