<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\Activity */
/* @var $form ActiveForm */
?>
<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id')->hiddenInput()->label(false, ['style' => 'display:none']) ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'start_timestamp')->widget("kartik\date\DatePicker", [
        'name' => 'start_timestamp',
        'options' => [
            'placeholder' => 'Выберите дату начала события',
            'value' => empty($model->start_timestamp) ? '' : Yii::$app->formatter->asDate($model->start_timestamp, 'php:d.m.Y'),
        ],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'php:d.m.Y',
            'todayHighlight' => true,
            'autoClose' => true
        ]
    ]) ?>
    <?= $form->field($model, 'end_timestamp')->widget("kartik\date\DatePicker", [
        'name' => 'end_timestamp',
        'options' => [
            'placeholder' => 'Выберите дату завершения события',
            'value' => empty($model->end_timestamp) ? '' : Yii::$app->formatter->asDate($model->end_timestamp, 'php:d.m.Y'),
        ],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'php:d.m.Y',
            'todayHighlight' => true,
            'autoClose' => true
        ]
    ]) ?>
    <?= $form->field($model, 'id_author') ?>
    <?= $form->field($model, 'body')->textarea() ?>
    <?= $form->field($model, 'is_recurrent')->checkbox() ?>
    <?= $form->field($model, 'is_all_day')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- activity-form -->
