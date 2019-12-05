<?php


namespace app\controllers;

use app\models\Activity;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;

class ActivityController extends Controller
{

   /**
     * Отображает событие с параметром $id события
     * @param $id - id требуемого события
     * @return string
     */
    public function actionShow($id)
    {
        if ($model = Activity::findOne($id)) {
            return $this->render('index', [
                'model' => $model
            ]);
        }
        //TODO: Сделать правильную обработку ситуации, когда событие не найдено
        echo 'Событие не найдено';
        die();
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
                return $this->render('index', ['model' => $model]);
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
            return $this->render('index', ['model' => $model]);
        }

        return $this->render('form', ['model' => $model]);
    }
}