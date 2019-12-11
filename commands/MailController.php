<?php


namespace app\commands;
use app\models\Activity;
use yii\console\Controller;

class MailController extends Controller
{
    public function actionSendOut($email= null)
    {
        $activitiesQuery = Activity::find();
        if ($email !== null) {
            $activitiesQuery->joinWith('users')->where(['user.email' => $email]);
        }
        foreach ($activitiesQuery->each(100) as $activity) {
            foreach ($activity->users as $user) {
                $mailSend = \Yii::$app->mailer
                    ->compose('activity/notification-html', ['activity' => $activity])
                    ->setFrom('noreply@test.gb')
                    ->setSubject('Список активностей')
                    ->setTo($user->email)->setCharset('UTF-8')
                    ->send();
            }
        }
    }
}