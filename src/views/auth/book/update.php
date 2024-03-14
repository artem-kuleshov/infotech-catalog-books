<?php

/** @var yii\web\View $this */
/** @var app\models\form\BookForm $model */
/** @var app\models\base\Book $book */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = "Update book {$book['name']}";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <a href="<?= Url::to(['delete', 'id' => $book['id']])?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')" >
                <i class="fa fa-trash"></i>
            </a>
            <?= $this->render('_form', compact('model', 'book'))?>
        </div>
    </div>
</div>
