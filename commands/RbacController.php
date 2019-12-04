<?php


namespace app\commands;


use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Администратор';
        try {
            Yii::$app->authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }

        $role = Yii::$app->authManager->createRole('simple');
        $role->description = 'Пользователь';
        try {
            Yii::$app->authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }
    }
}
