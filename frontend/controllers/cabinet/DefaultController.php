<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 08.04.2020
 * Time: 9:22
 */

namespace frontend\controllers\cabinet;


use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}