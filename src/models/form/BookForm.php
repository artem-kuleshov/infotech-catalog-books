<?php

namespace app\models\form;

use app\models\base\Book;
use app\models\User;
use Yii;
use yii\base\Model;


class BookForm extends Model
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';

    public $name;
    public $year;
    public $description;
    public $isbn;
    public $image;
    public $co_authors;

    private $path_file = '';

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['name', 'year', 'isbn'], 'required'],
            [['name', 'description'], 'trim'],
            ['year', 'integer'],
            [['year'], 'date', 'format' => 'php:Y'],
            ['co_authors', 'each', 'rule' => ['integer']],
            ['co_authors', 'checkExistUsers'],
            ['name', 'unique', 'targetClass' => Book::class],
            ['isbn', 'match', 'pattern' => '/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'on' => self::SCENARIO_CREATE],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg', 'on' => self::SCENARIO_UPDATE],
        ];
    }

    public function checkExistUsers($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $exist = User::find()->where(['in', 'id', $this->co_authors])->exists();
            if (!$exist) {
                $this->addError($attribute, 'Co authors don\'t exist');
            }
        }
    }

    public function add(): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->uploadFile();
            $this->save();
            $transaction->commit();

            \Yii::$app->session->setFlash('success', "Книга '{$this->name}' добавлен");
            return true;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Возникла непредвиденная ошибка при добавлении книги. Попробуйте позже");
            $this->removeFile();
            $transaction->rollBack();

            return false;
        }
    }

    public function update(Book $book): bool
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->path_file = $book->main_image;

            if ($this->image) {
                $this->removeFile();
                $this->uploadFile();
            }
            $this->save($book);
            $transaction->commit();

            \Yii::$app->session->setFlash('success', "Книга '{$this->name}' обновлена");
            return true;
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', "Возникла непредвиденная ошибка при обновлении книги. Попробуйте позже");
            $this->removeFile();
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws \yii\db\Exception
     */
    public function save(Book $book = null): bool
    {
        if (!$book) {
            $book = new Book();
        }
        $book->name = $this->name;
        $book->year = $this->year;
        $book->isbn = $this->isbn;
        $book->description = $this->description;
        $book->user_id = Yii::$app->user->identity->getId();
        $book->main_image = $this->path_file;

        if ($book->save(false)) {
            $this->co_authors = $this->co_authors ?: [];
            $book->saveSoAuthors($this->co_authors);

            return true;
        }

        return false;
    }

    public function uploadFile()
    {
        $this->path_file = 'uploads/' . $this->image->baseName . time() . '.' . $this->image->extension;
        $this->image->saveAs($this->path_file);
    }

    public function removeFile()
    {
        if (file_exists($this->path_file)) {
            unlink($this->path_file);
        }
    }
}