<?php


namespace app\commands;


use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll();

        $role = $authManager->createRole('admin');
        $role->description = 'Администратор';
        try {
            $authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }

        $role = $authManager->createRole('simple');
        $role->description = 'Пользователь';
        try {
            $authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }
    }
}
