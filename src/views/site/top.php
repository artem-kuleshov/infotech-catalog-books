<?php

/** @var yii\web\View $this */
/** @var \app\models\form\TopForm $model->year */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Top authors of {$model->year}";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

    <div class="row mb-3">
        <div class="col-12 d-flex">
            <form action="<?=Url::to(['site/top'])?>">
                <div class="mb-3 me-3">
                    <label class="col-form-label" for="year">Date</label>
                    <input type="number" name="year" id="year" min="1900" max="<?=date('Y')?>" step="1" value="<?=$model->year?>" />
                </div>
                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-primary">Get top</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if (!empty($users)):?>
                <hr class="mt-0"/>
                <?php foreach ($users as $user):?>
                    <p class="mb-2">
                        Автор:<strong> <?=User::getFullName($user)?></strong> <br/>
                        Выпущено книг: <strong><?=$user['count']?></strong>
                    </p>
                <hr/>
                <?php endforeach;?>
            <?php else:?>
                <p>За <?=$model->year?> г. книг не найдено</p>
            <?php endif;?>
        </div>
    </div>

</div>
