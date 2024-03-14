<?php

/** @var yii\web\View $this */
/** @var app\models\form\BookForm $model */

use yii\bootstrap5\Html;

$this->title = 'Create book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?= $this->render('_form', compact('model'))?>
        </div>
    </div>
</div>
