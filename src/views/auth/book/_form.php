<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\form\BookForm $model */

use app\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
        'inputOptions' => ['class' => 'col-lg-3 form-control'],
        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
    ],
]); ?>

<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'year')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'isbn')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>

<?php if (isset($book)):?>
    <img src="/<?=$book['main_image']?>" alt="<?=$book['name']?>" height="150">
<?php endif;?>

<?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']) ?>

<?=$form->field($model, 'co_authors')->dropDownList(
        ArrayHelper::map(User::find()
            ->select(["id", "CONCAT(first_name, ' ', last_name, ' ', patronymic) as full_name"])
            ->where(["!=", "id", Yii::$app->user->getId()])
            ->orderBy('first_name')
            ->asArray()
            ->all(), 'id', 'full_name'), [
    'class' => 'select2',
    'multiple' => true
]);?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>