<?php


namespace app\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionHello() {
        return $this->render('hello');
    }
}