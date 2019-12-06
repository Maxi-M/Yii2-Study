<?php


namespace app\controllers;

use app\models\Activity;
use Yii;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ActivityController extends Controller
{
    /**
     * Отображает список событий с использованием ActiveDataProvider
     */
    public function actionIndex()
    {
        $activitiesProvider = new ActiveDataProvider([
            'query' => Activity::find()->where(['id_author' => Yii::$app->user->id]),
            'pagination' => [
                'pageSize' =>15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('index', ['provider' => $activitiesProvider]);
    }

    /**
     * Отображает событие с параметром $id события
     * @return string
     */
    public function actionShow():string
    {
        $id = \Yii::$app->request->get('id');

        if ($id > 0) {
            if ($model = Activity::findOne($id)) {
                if ($model->id_author === Yii::$app->user->id) {
                    return $this->render('show', [
                        'model' => $model
                    ]);
                }
                return $this->render('activity-error', [
                    'name' => 'Ошибка обращения к событиям',
                    'message' => 'Доступ запрещён'
                ]);
            }
            return $this->render('activity-error', [
                'name' => 'Ошибка обращения к событиям',
                'message' => 'Событие не найдено'
            ]);
        }
        return $this->render('activity-error', [
            'name' => 'Ошибка обращения к событиям',
            'message' => 'Параметр отсутствует, либо имеет недопустимое значение'
        ]);
    }

    /**
     * Отображает страницу редактирования выбранного события
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        if ($model = Activity::findOne(['id' => $id])) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                return $this->render('show', ['model' => $model]);
            }
        } else {
            //TODO: Сделать правильную обработку ситуации, когда событие не найдено
            echo 'Событие не найдено';
            die();
        }
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Activity();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->render('show', ['model' => $model]);
        }

        return $this->render('form', ['model' => $model]);
    }
}