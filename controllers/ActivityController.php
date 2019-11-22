<?php


namespace app\controllers;


use app\models\Activity;
use yii\web\Controller;

class ActivityController extends Controller
{

    public function actionIndex()
    {
        $model = new Activity();
        $model->title = 'Lorem ipsum dolor sit amet.';
        $model->startDay = time();
        $model->endDay = $model->startDay + 24 * 60 * 60;
        $model->body = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab alias amet deserunt dolorem doloribus in magnam maxime minus molestiae nisi, non nostrum praesentium quaerat, quis quod repellat repudiandae, sed vero.';

        return $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        return $this->render('create');
    }
}