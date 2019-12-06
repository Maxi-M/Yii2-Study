<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(
            ['validationUrl' => '/user/ajax-validate']
    ); ?>
        <?= $form->field($model, 'id')->hiddenInput()->label(false, ['style' => 'display:none']) ?>
        <?= $form->field($model, 'username', ['enableAjaxValidation' => true]) ?>
        <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'surname') ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password2')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-form -->
