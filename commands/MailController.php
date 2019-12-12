<?php


namespace app\commands;

use app\models\Activity;
use yii\console\Controller;

class MailController extends Controller
{
    public function actionSendOut($email = null)
    {
        // Формируем запрос
        $activitiesQuery = Activity::find();
        // Если указан конкретный адрес, то добавим фильтрацию сразу по нему
        if ($email !== null) {
            $activitiesQuery->joinWith('user')->where(['users.email' => $email]);
        }
        // Отберём те активности, с которыми пересекается сегодняшняя дата
        $activitiesQuery->andWhere(['<=', 'CAST(start_timestamp AS DATE)', date('Y-m-d')])
            ->andWhere(['>=', 'CAST(end_timestamp AS DATE)', date('Y-m-d')])
            ->all();

        // Разберём активности по пользователям
        $userActivities = [];
        foreach ($activitiesQuery->each(100) as $activity) {
            if (!isset($userActivities[$activity->user->email])) {
                $userActivities[$activity->user->email] = [];
            }
            $userActivities[$activity->user->email][] = $activity;
        }
        foreach ($userActivities as $mail => $activities) {
            \Yii::$app->mailer
                ->compose('activity/notification-html', ['activities' => $activities])
                ->setFrom('noreply@test.gb')
                ->setSubject('Список активностей на сегодня')
                ->setTo($mail)->setCharset('UTF-8')
                ->send();
        }
    }
}