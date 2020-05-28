<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 08.04.2020
 * Time: 9:25
 */

use yii\helpers\Html;

$this->title = 'Cabinet';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Hello!</p>

    <h2>Attach profile</h2>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['cabinet/network/attach'],
    ]); ?>
</div>