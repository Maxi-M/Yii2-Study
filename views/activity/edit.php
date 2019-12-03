<?php

use app\models\Activity;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Activity */

$form = ActiveForm::begin();
$form->action = Url::to(['activity/submit']);?>

<?=$form->field($model, 'id')->hiddenInput()->label(false, ['style'=>'display:none'])?>
<?=$form->field($model, 'title')->label($model->getAttributeLabel('title'))?>
<?=$form->field($model, 'startDay')->label($model->getAttributeLabel('startDay'))->widget(DateTimePicker::className(), [
    'options' => [
        'placeholder' => 'Дата начала события...',
        'value' => Yii::$app->formatter->asDatetime($model->startDay),
        ],
    'convertFormat' => true,
    'pluginOptions' => [
        'autoClose' => true,
        'format' => 'php:d-m-Y H:i:s'
    ],

])?>
<?=$form->field($model, 'endDay')->label($model->getAttributeLabel('endDay'))->widget(DateTimePicker::className(), [
    'options' => [
        'placeholder' => 'Дата окончания события...',
        'value' => Yii::$app->formatter->asDatetime($model->endDay),
    ],
    'convertFormat' => true,
    'pluginOptions' => [
        'autoClose' => true,
        'format' => 'php:d-m-Y H:i:s'
    ],
])
?>
<?=$form->field($model, 'body')->textarea()->label($model->getAttributeLabel('body'))?>
<?=$form->field($model, 'isRecurrent')->checkbox()?>
<?=$form->field($model, 'isAllDay')->checkbox()?>
<?=Html::submitButton('Отправить', ['class' => 'btn btn-success'])?>
<?php ActiveForm::end()?>


