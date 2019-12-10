<?php

use app\models\User;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */
/* @var $provider ActiveDataProvider */
/* @var $data User */


echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'label' => 'Логин',
            'attribute' => 'username',
            'value' => static function ($data) {
                return $data->username;
            }
        ],
        [
            'label' => 'E-mail',
            'attribute' => 'email',
            'value' => static function ($data) {
                return $data->email;
            },
        ],
        [
            'label' => 'Дата регистрации',
            'attribute' => 'created_at',
            'value' => function ($data) {
                return $data->created_at;
            },
        ],
        [
            'label' => 'ФИО',
            'value' => function ($data) {
                return $data->name. ' '.$data->surname;
            },
        ],
        [
            'class' => ActionColumn::class,
            'urlCreator' => static function ($action, $model, $key, $index) {
                if ($action === 'view') {
                    return Url::to(['user/show', 'id' => $model->id]);
                }
                if ($action === 'update') {
                    return Url::to(['user/edit', 'id' => $model->id]);
                }
                if ($action === 'delete') {
                    return Url::to(['user/delete', 'id' => $model->id]);
                }
            }
        ]]
]);

echo Html::a('Создать нового пользователя', Url::to(['user/create']), ['class' => 'btn btn-success']);