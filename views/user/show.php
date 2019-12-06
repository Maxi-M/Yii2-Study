<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\User */

use yii\helpers\Html;
use yii\helpers\Url; ?>

<h1>Страница пользователя</h1>

<h3>Логин:</h3> <?= $model->username ?>
<h3>E-mail:</h3> <?= $model->email ?>
<h3>Имя:</h3> <?= $model->name ?>
<h3>Фамилия:</h3> <?= $model->surname ?>
<h3>Телефон:</h3> <?= $model->phone ?>
<h3>Дата создания записи:</h3> <?= date('d.m.Y H:i:s', strtotime($model->created_at)) ?>
<h3>Дата обновления записи:</h3> <?= date('d.m.Y H:i:s', strtotime($model->updated_at)) ?>

<?= Html::a('Редактировать', Url::to(['user/edit', 'id' => $model->id]), ['class'=>'btn btn-success', 'style'=>'display:block']) ?>
