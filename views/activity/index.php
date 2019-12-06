<?php

use yii\grid\ActionColumn;
use app\models\Activity;
use yii\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $provider ActiveDataProvider */
/* @var $data Activity */


echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'label' => 'Название события',
            'attribute' => 'name',
            'value' => static function ($data) {
                return $data->title;
            }
        ],
        [
            'label' => 'Дата начала',
            'attribute' => 'activity_start_timestamp ',
            'value' => static function ($data) {
                return $data->startDay;
            },
        ],
        [
            'label' => 'Дата завершения',
            'attribute' => 'activity_end_timestamp ',
            'value' => function ($data) {
                return $data->endDay;
            },
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => static function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    return Url::to(['activity/show', 'id' => $model->id]);
                }
                if ($action === 'update') {
                    return Url::to(['activity/edit', 'id' => $model->id]);
                }
                if ($action === 'delete') {
                    return Url::to(['activity/delete', 'id' => $model->id]);
                }
            }
        ]]
]);

echo Html::a('Создать новое событие', Url::to(['activity/create']), ['class' => 'btn btn-success']);