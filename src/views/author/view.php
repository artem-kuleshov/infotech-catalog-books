<?php

/** @var yii\web\View $this */
/** @var array $books */
/** @var array $author */
/** @var yii\data\Pagination $pages */

use app\models\User;
use yii\helpers\Html;

$this->title = User::getFullName($author);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1 class="mb-3">
        <?= Html::encode($this->title) ?> (<?=$pages->totalCount?>)
        <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#subscribe-modal">Subscribe</a>
    </h1>

    <!-- Modal -->
    <div class="modal fade" id="subscribe-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enter your phone number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="author_id" value="<?=$author['id']?>">
                    <div class="mb-3 me-3">
                        <label class="col-form-label" for="phone">phone</label>
                        <input type="number" id="phone" placeholder="89999999999" pattern="/^(8|7)(\d{10})/" />
                    </div>
                    <div class="text-danger" id="errors"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="subscribe" type="button" class="btn btn-primary">Subscribe</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('/include/_books', compact('books', 'pages'))?>
</div>
