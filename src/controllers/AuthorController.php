<?php

namespace app\controllers;

use app\models\base\Book;
use app\models\form\SubscribeForm;
use app\models\Helper;
use app\models\User;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorController extends Controller
{
    #[ArrayShape(['verbs' => "array"])] public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'subscribe' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     *
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): Response|string
    {
        $author = User::find()->where(['id' => $id])->asArray()->one();
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден');
        }

        $query = Book::find()->joinWith(['authors'])->where(['user.id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'forcePageParam' => false, 'pageSizeParam' => false]);
        $books = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('view', compact('books', 'pages', 'author'));
    }

    public function actionSubscribe(): Response
    {
        $this->layout = false;

        $model = new SubscribeForm();
        $model->attributes = Yii::$app->request->post();

        if (!$model->validate()) {
            return $this->asJson(['errors' => Helper::returnErrorsString($model->getErrors())]);
        }

        if (!$model->subscribe()) {
            return $this->asJson(['errors' => "Возникла непредвиденная ошибка. Попробуйте позже"]);
        }

        Yii::$app->session->setFlash('success', 'Вы успешно подписались на этого автора');
        return $this->asJson([]);
     }
}
