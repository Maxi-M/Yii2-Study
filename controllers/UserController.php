<?php


namespace app\controllers;


use app\models\User;
use Yii;
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
    public function actionShow($id): string
    {
        if ($model = User::findOne($id)) {
            return $this->render('show', ['model' => $model]);
        }
        //TODO: Сделать правильную обработку ситуации, когда пользователь не найден
        echo 'Пользователь не найден';
        die();
    }

    public function actionCreate(): string
    {
        $model = new User(['scenario' => User::SCENARIO_CREATE_USER]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->render('show', ['model' => $model]);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionEdit($id): string
    {
        if ($model = User::findOne($id)) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                return $this->render('show', ['model' => $model]);
            }
        } else {
            //TODO: Сделать правильную обработку ситуации, когда пользователь не найден
            echo 'Пользователь не найден';
            die();
        }
        return $this->render('form', ['model' => $model]);
    }

    public function actionSubmit()
    {
        $model = new User();


        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            $model = User::findOne($model->id);
            return $this->render('show', ['model' => $model]);
        }
        var_dump($model->getErrors());
    }

    /**
     * Обрабатывает Ajax запросы валидации
     * @return array
     */
    public function actionAjaxValidate()
    {
        $model = new User();
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }
}