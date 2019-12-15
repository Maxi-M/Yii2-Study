<?php

/* @var $this \yii\web\View */
/* @var $events \edofre\fullcalendar\models\Event[] */

echo edofre\fullcalendar\Fullcalendar::widget([
    'events' => $events,
    'clientOptions' => [
        'weekNumbers' => true,
        'selectable' => true,
    ],
]);
