<?php


/* @var $this \yii\web\View */
/* @var $users \app\models\Activity[]|\app\models\User[]|array|\yii\db\ActiveRecord[] */

use yii\helpers\Html;
use yii\helpers\Url; ?>
<h1>Список пользователей</h1>

<?= Html::a('Создать нового пользователя', Url::to(['user/create']), ['class'=>'btn btn-success']) ?>
<?php foreach ($users as $user): ?>
    <?= Html::a($user->username, Url::to(['user/show', 'id' => $user->id]), ['style'=>'display:block']) ?>
<?php endforeach; ?>