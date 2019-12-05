<?php


namespace app\controllers;


use app\models\Activity;
use Yii;
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
        $model = Activity::findOne(['id' => $id]);
        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Отображает страницу редактирования выбранного события
     * @param $id
     * @return string
     */
    public function actionEdit($id)
    {
        $model = Activity::findOne(['id' => $id]);

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Обрабатывает работу с формой в режиме правки существующего события, либо создания нового.
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionForm()
    {
        $model = new Activity();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($model->id) && $dbModel = Activity::findOne($model->id)) {
                $dbModel->title = $model->title;
                $dbModel->start_timestamp = $model->start_timestamp;
                $dbModel->end_timestamp = $model->end_timestamp;
                $dbModel->is_recurrent = $model->is_recurrent;
                $dbModel->is_all_day = $model->is_all_day;
                $dbModel->body = $model->body;
                $model = $dbModel;
            }
            $model->save();
            return $this->render('index', [
                'model' => $model,
            ]);
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }
}