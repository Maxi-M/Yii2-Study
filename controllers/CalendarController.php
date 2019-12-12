<?php


namespace app\controllers;


use app\models\Activity;
use edofre\fullcalendar\models\Event;
use yii\web\Controller;

class CalendarController extends Controller
{
    /**
     * Отображает полный календарь
     */
    public function actionViewFull()
    {
        $activities = Activity::find()->andWhere(['id_author', \Yii::$app->user->id])->all();
        return $this->render('month', ['events' => $this->prepareEvents($activities)]);
    }

    /**
     * Принимает массив событий, преобразует к требуемому для виджета виду событий
     * @param Activity $activities []
     * @return Event[]
     */
    protected function prepareEvents($activities)
    {
        $events =[];
        /**
         * @var $activity Activity
         */
        foreach ($activities as $activity) {
            $events[] = new Event([
                'id' => $activity->id,
                'title' => $activity->title,
                'start' => $activity->start_timestamp,
                'end' => $activity->end_timestamp,
            ]);
        }
        return $events;
    }

}