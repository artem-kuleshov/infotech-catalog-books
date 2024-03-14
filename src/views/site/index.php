<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Catalog books';
?>
<div class="site-about">
    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>
    <?= $this->render('/include/_books', compact('books', 'pages'))?>
</div>
