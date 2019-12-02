<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Activity */

$this->title='Информация о событии';

use yii\helpers\Html;
use yii\helpers\Url; ?>

<h1>Название события: <?=$model->title; ?></h1>

<?php if($model->getStartDay() === $model->getEndDay()): ?>
    <p>Событие на <?=$model->getStartDay()?></p>
<?php else: ?>
    <p>Событие c <?=$model->getStartDay()?> <?=$model->getStartTime()?> по <?=$model->getEndDay()?> <?=$model->getStartTime()?></p>
<?php endif; ?>

<h3><?=$model->getAttributeLabel('body') ?></h3>
<div><?=$model->body ?></div>

<?= Html::a('Редактировать', Url::to(['activity/edit', 'id' => $model->id]), ['class'=>'btn btn-success']) ?>
<?= Html::a('Назад в календарь', Url::to(['site/calendar']), ['class'=>'btn btn-warning']) ?>
