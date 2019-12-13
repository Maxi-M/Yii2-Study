<?php


/* @var $this \yii\web\View */
/* @var $user \app\models\User|null */

/* @var $provider \yii\data\ActiveDataProvider */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

<h1>Профиль пользователя</h1>

<div class="user-form">

    <?php $form = ActiveForm::begin(
        ['validationUrl' => '/user/ajax-validate']
    ); ?>
    <?= $form->field($user, 'id')->hiddenInput()->label(false, ['style' => 'display:none']) ?>
    <?= $form->field($user, 'username')->textInput(['readOnly' => $user->scenario === \app\models\User::SCENARIO_EDIT_OWN_PROFILE ? 'true' : false]) ?>
    <?= $form->field($user, 'email', ['enableAjaxValidation' => true]) ?>
    <?= $form->field($user, 'name') ?>
    <?= $form->field($user, 'surname') ?>
    <?= $form->field($user, 'phone') ?>
    <?= $form->field($user, 'password')->passwordInput() ?>
    <?= $form->field($user, 'password2')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-form -->

<h1>Мои активности</h1>

<?php
echo GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        ['class' => SerialColumn::class],
        [
            'label' => 'Название события',
            'attribute' => 'title',
        ],
        [
            'label' => 'Дата начала',
            'attribute' => 'startDay',
        ],
        [
            'label' => 'Дата завершения',
            'attribute' => 'endDay',
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