<?php

/** @var yii\web\View $this */

use app\models\User;
use yii\bootstrap5\LinkPager;
use yii\helpers\Url;

?>

<div class="row mb-3">
    <?php if (!empty($books)):?>
        <?php foreach ($books as $book):?>
            <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                <div class="row">
                    <div class="col-5">
                        <a href="<?=Url::to(['site/view', 'id' => $book['id']])?>">
                            <img src="/<?=$book['main_image']?>" class="figure-img img-fluid rounded" alt="<?=$book['name']?>"
                                 style="max-height: 250px">
                        </a>
                    </div>
                    <div class="col-7">
                        <a href="<?=Url::to(['site/view', 'id' => $book['id']])?>">
                            <h4><?=$book['name']?></h4>
                        </a>
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
                                </small>
                                <br/>
                                <?php endforeach;?>
                            <?php endif;?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    <?php else:?>
    <?php endif;?>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'class' => 'justify-content-center'
        ]); ?>
    </div>
</div>