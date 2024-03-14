<?php

namespace app\controllers\auth;

use app\models\base\Book;
use app\models\form\BookForm;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class BookController extends AppController
{
    /**
     * Create action.
     *
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new BookForm();
        $model->scenario = BookForm::SCENARIO_CREATE;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate() && $model->add()) {
                return $this->goHome();
            }
        }

        return $this->render('create', compact('model'));
    }

    /**
     * @param int $id
     *
     * @return string|Response
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate(int $id): Response|string
    {
        $book = $this->findModel($id);
        $this->checkAccess($book);

        $model = new BookForm();
        $model->scenario = BookForm::SCENARIO_UPDATE;
        $model->attributes = $book->attributes;
        $model->co_authors = $book->getauthors()->select('id')->column();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate() && $model->update($book)) {
                return $this->goHome();
            }
        }

        return $this->render('update', compact('model', 'book'));
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $book = $this->findModel($id);
        $this->checkAccess($book);

        $book->delete();

        Yii::$app->session->setFlash('success', 'Книга удалена');
        return $this->goHome();
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Book
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Книга не найден');
    }

    /**
     * @throws ForbiddenHttpException
     */
    protected function checkAccess(Book $book)
    {
        if ($book->user_id != Yii::$app->user->getId()) {
            throw new ForbiddenHttpException('Нет доступа');
        }
    }
}
