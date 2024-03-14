<?php

namespace app\controllers\auth;

use JetBrains\PhpStorm\ArrayShape;
use yii\filters\AccessControl;
use yii\web\Controller;

class AppController extends Controller
{
    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['access' => "array"])]
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }
}
