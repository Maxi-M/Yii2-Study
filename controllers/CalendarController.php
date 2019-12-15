<?php


namespace app\controllers;


use app\models\Activity;
use edofre\fullcalendar\models\Event;
use yii\helpers\Url;
use yii\web\Controller;

class CalendarController extends Controller
{
    /**
     * Отображает полный календарь
     * @throws \yii\base\InvalidConfigException
     */
    public function actionViewFull()
    {
        if (!\Yii::$app->user->isGuest) {
            $activities = Activity::find()->andWhere(['id_author' => \Yii::$app->user->id])->all();
        }
        Url::remember();
        return $this->render('month', ['events' => $this->prepareEvents($activities)]);
    }

    /**
     * Принимает массив событий, преобразует к требуемому для виджета виду событий
     * @param Activity $activities []
     * @return Event[]
     * @throws \yii\base\InvalidConfigException
     */
    protected function prepareEvents($activities)
    {
        $events = [];
        /**
         * @var $activity Activity
         */
        foreach ($activities as $activity) {
            $startTimestamp = strtotime($activity->start_timestamp);
            $start = \Yii::$app->formatter->asDate($startTimestamp, 'php:Y-m-d').'T'.\Yii::$app->formatter->asTime($startTimestamp, 'php:H:i:s');

            $endTimestamp = strtotime($activity->end_timestamp);
            $end = \Yii::$app->formatter->asDate($endTimestamp, 'php:Y-m-d').'T'.\Yii::$app->formatter->asTime($endTimestamp, 'php:H:i:s');

            $events[] = new Event([
                'id' => $activity->id,
                'title' => $activity->title,
                'start' => $start,
                'end' => $end,
                'editable'         => false,
                'startEditable'    => true,
                'durationEditable' => true,
                'allDay' => $activity->is_all_day,
                'url' => Url::to(['/activity/edit', 'id' => $activity->id]),
            ]);
        }
        return $events;
    }

}