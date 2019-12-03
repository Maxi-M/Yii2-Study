<?php


namespace app\controllers;


use app\models\Activity;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class ActivityController extends Controller
{
   /**
     * Отображает страницу создания нового события
     * @return string
     */
    public function actionCreate()
    {
        return $this->render('edit', ['model'=>new Activity()]);
    }

    /**
     * Отображает событие с параметром $id события
     * @param $id - id требуемого события
     * @return string
     */
    public function actionShow($id)
    {
        $model = ArrayHelper::getValue(\Yii::$app->dummy->activities, $id);
        return $this->render('index', ['model' => $model]);
    }

    /**
     * Отображает страницу редактирования выбранного события
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $model = ArrayHelper::getValue(\Yii::$app->dummy->activities, $id);
        return $this->render('edit', ['model' => $model]);
    }

    public function actionSubmit()
    {
        $model = new Activity();
        $model->load(\Yii::$app->request->post());
        return $this->render('index', ['model' => $model]);
    }
}