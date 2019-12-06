<?php

/* @var $this \yii\web\View */

use app\models\Activity;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var Activity $activities [] */
?>

    <h1>Импровизированный календарь</h1>
    <p>Представляет собой заглушку в виде списка событий</p>

<?= Html::a('Создать новое событие', Url::to(['activity/create']), ['class'=>'btn btn-success']) ?>
<?php foreach ($activities as $activity): ?>
    <?= Html::a($activity->title, Url::to(['activity/show', 'id' => $activity->id]), ['style'=>'display:block']) ?>
<?php endforeach; ?>