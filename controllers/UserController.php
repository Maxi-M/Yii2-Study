<?php


namespace app\controllers;


use app\models\User;
use yii\base\Model;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class UserController
 * @package app\controllers
 *
 * Обрабатывает действия с учётной записью пользователя (создание, обновление, удаление, блокировка и так далее.)
 */
class UserController extends Controller
{
    public function actionShow($id)
    {
        if ($model = User::findOne($id)) {
            return $this->render('show', ['model' => $model]);
        }
        echo 'There is no such user!';
    }

    public function actionCreate()
    {
        $model = new User();
        return $this->render('form', ['model' => $model]);
    }

    public function actionEdit($id)
    {
        if ($model = User::findOne($id)) {
            return $this->render('form', ['model' => $model]);
        }
        echo 'There is no such user!';
    }

    public function actionSubmit()
    {
        $model = new User();
        // Для Ajax валидации
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            $model = User::findOne($model->id);
            return $this->render('show', ['model' => $model]);
        }
        var_dump($model->getErrors());
    }
}