<?php

/* @var $this \yii\web\View */
/* @var $model \app\models\Activity */
$this->title='Информация о событии';

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        'body:html',
        [
            'label' => 'Автор',
            'value' => $model->id_author,
            'contentOptions' => ['class' => 'bg-red'],
            'captionOptions' => ['tooltip' => 'Tooltip'],
        ],
        'start_timestamp:datetime',
        'end_timestamp:datetime'
    ],
]);


?>

<?= Html::a('Редактировать', Url::to(['activity/edit', 'id' => $model->id]), ['class'=>'btn btn-success']) ?>
<?= Html::a('Назад в календарь', Url::to(['site/calendar']), ['class'=>'btn btn-warning']) ?>
