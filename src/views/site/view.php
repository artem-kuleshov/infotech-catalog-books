<?php

/** @var yii\web\View $this */
/** @var app\models\base\Book $book */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Book {$book['name']}";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-5">
                    <img src="/<?=$book['main_image']?>" class="figure-img img-fluid rounded" alt="<?=$book['name']?>"
                         style="max-height: 250px">
                </div>
                <div class="col-7">
                    <?php if (!Yii::$app->user->isGuest && $book['user_id'] == Yii::$app->user->getId()):?>
                        <div class="mt-2">
                            <a href="<?= Url::to(['auth/book/update', 'id' => $book['id']])?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="<?= Url::to(['auth/book/delete', 'id' => $book['id']])?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')" >
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    <?php endif;?>
                    <p class="mb-0">ISBN: <strong><?=$book['isbn']?></strong></p>
                    <p class="mb-0">Год: <strong><?=$book['year']?> г.</strong></p>
                    <p class="mb-0">
                        Авторы: <br/>
                        <?php if ($book['authors']):?>
                            <?php foreach ($book['authors'] as $author):?>
                                <small>
                                    <a href="<?=Url::to(['author/view', 'id' => $author['id']])?>">
                                        <?= User::getFullName($author)?>
                                    </a>
                                </small><br/>
                            <?php endforeach;?>
                        <?php endif;?>
                    </p>
                    <p class="mb-0">Описание: <?=$book['description']?></p>
                </div>
            </div>
        </div>
    </div>
</div>
