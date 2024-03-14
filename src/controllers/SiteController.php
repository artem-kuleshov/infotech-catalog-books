<?php

namespace app\controllers;

use app\models\base\Book;
use app\models\form\RegistrationForm;
use app\models\form\TopForm;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\form\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['access' => "array", 'verbs' => "array"])]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['error' => "string[]", 'captcha' => "array"])]
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $query = Book::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'forcePageParam' => false, 'pageSizeParam' => false]);
        $books = $query->with(['authors'])->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->render('index', compact('books', 'pages'));
    }

    public function actionTop(int $year = null): string
    {
        if (!$year) $year = date('Y');

        $model = new TopForm();
        $model->year = $year;
        if ($model->validate()) {
            $users = $model->get();
        }

        return $this->render('top', compact('users', 'model'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     *
     * @return Response|string
     * @throws \yii\base\Exception
     */
    public function actionRegister(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', "Вы успешно зарегистрировались. Логин: {$model->login} пароль {$model->password}");
            return $this->goHome();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $book = Book::find()->with(['authors', 'user'])->where(['id' => $id])->asArray()->one();
        if (!$book) {
            throw new NotFoundHttpException('Книга не найден');
        }

        return $this->render('view', compact('book'));
    }
}
