<?php


namespace app\controllers;


use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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
    /**
     * Выводит список всех пользователей системы
     */
    public function actionIndex()
    {
        $usersProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ]
        ]);
        return $this->render('index', ['provider' => $usersProvider]);
    }
    public function actionShow($id): string
    {
        if ($model = User::findOne($id)) {
            return $this->render('show', ['model' => $model]);
        }
        //TODO: Сделать правильную обработку ситуации, когда пользователь не найден
        echo 'Пользователь не найден';
        die();
    }

    public function actionCreate()
    {
        $model = new User(['scenario' => User::SCENARIO_CREATE_USER]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            return Yii::$app->getResponse()->redirect(['user/show', 'id' =>$model->id]);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionEdit($id)
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