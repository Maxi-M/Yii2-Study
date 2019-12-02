<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \app\models\Activity $activities [] */
?>

    <h1>Импровизированный календарь</h1>
    <p>Представляет собой заглушку в виде списка событий</p>

<?php foreach ($activities as $activity): ?>

    <?= Html::a($activity->title, Url::to(['activity/show', 'id' => $activity->id]), ['style'=>'display:block']) ?>
<?php endforeach; ?>