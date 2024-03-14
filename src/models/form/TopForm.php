<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use yii\db\DataReader;


class TopForm extends Model
{
    public $year;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [ 'year', 'required'],
            ['year', 'integer'],
            [['year'], 'date', 'format' => 'php:Y'],
        ];
    }

    public function get(): DataReader|array
    {
        $sql = <<<SQL
SELECT bu.user_id, u.first_name, u.last_name, u.patronymic, count(*) as count FROM book b
LEFT JOIN book_user bu on b.id = bu.book_id
LEFT JOIN user u on u.id = bu.user_id
WHERE year = :year
GROUP BY bu.user_id
ORDER BY count DESC
LIMIT 10
SQL;

        return Yii::$app->db->createCommand($sql, [':year' => $this->year])->queryAll();
    }
}