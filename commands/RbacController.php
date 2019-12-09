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

        // Создаём роль админа
        $role = $authManager->createRole('admin');
        $role->description = 'Администратор';
        try {
            $authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }

        // Cоздаём роль простого пользователя
        $role = $authManager->createRole('simple');
        $role->description = 'Пользователь';
        try {
            $authManager->add($role);
        } catch (\Exception $e) {
            echo 'Role has not been added';
        }

        // Правило проверки является ли пользователь владельцем активности
        $ownerRule = new \app\rbac\ActivityOwnerRule();
        $authManager->add($ownerRule);

        // Разрешение создавать события
        $createActivity = $authManager->createPermission('create_activity');
        $createActivity->description = 'Создание события';

        // Разрешение просмотра событий
        $viewActivity = $authManager->createPermission('view_activity');
        $viewActivity->description = 'Просмотр события';

        $viewOwnActivity = $authManager->createPermission('view_own_activity');
        $viewOwnActivity->description = 'Просмотр собственного события';
        $viewOwnActivity->ruleName = $ownerRule->name;

        // Разрешение редактирования события
        $editActivity = $authManager->createPermission('edit_activity');
        $editActivity->description = 'Редактирование события';

        $editOwnActivity = $authManager->createPermission('edit_own_activity');
        $editOwnActivity->description = 'Редактирование собственного события';
        $editOwnActivity->ruleName = $ownerRule->name;

        // Разрешение удалять событие
        $deleteActivity = $authManager->createPermission('delete_activity');
        $deleteActivity->description = 'Удаление события';

        // Разрешение удалять событие
        $deleteOwnActivity = $authManager->createPermission('delete_own_activity');
        $deleteOwnActivity->description = 'Удаление собственного события';
        $deleteOwnActivity->ruleName = $ownerRule->name;

        $createUser = $authManager->createPermission('create_user');
        $createUser->description = 'Создание пользователя';

        // Разрешение просмотра пользователя
        $viewUser = $authManager->createPermission('view_user');
        $viewUser->description = 'Просмотр пользователя';

        // Разрешение изменения пользователей
        $editUser = $authManager->createPermission('edit_user');
        $editUser->description = 'Редактирование профиля';

        $deleteUser = $authManager->createPermission('delete_user');
        $deleteUser->description = 'Удаление пользователя';

        $authManager->add($createActivity);
        $authManager->add($viewActivity);
        $authManager->add($viewOwnActivity);
        $authManager->add($editActivity);
        $authManager->add($editOwnActivity);
        $authManager->add($deleteActivity);
        $authManager->add($deleteOwnActivity);
        $authManager->add($createUser);
        $authManager->add($viewUser);
        $authManager->add($editUser);
        $authManager->add($deleteUser);

        $authManager->addChild($viewOwnActivity, $viewActivity);
        $authManager->addChild($editOwnActivity, $editActivity);
        $authManager->addChild($deleteOwnActivity, $deleteActivity);

        $role = $authManager->getRole('simple');
        $authManager->addChild($role, $createActivity);
        $authManager->addChild($role, $viewOwnActivity);
        $authManager->addChild($role, $editOwnActivity);
        $authManager->addChild($role, $deleteOwnActivity);

        $role = $authManager->getRole('admin');
        $authManager->addChild($role, $viewActivity);
        $authManager->addChild($role, $editActivity);
        $authManager->addChild($role, $deleteActivity);
        $authManager->addChild($role, $createUser);
        $authManager->addChild($role, $viewUser);
        $authManager->addChild($role, $editUser);
        $authManager->addChild($role, $deleteUser);

        // Унаследуем администратору все разрешения простого пользователя
        $authManager->addChild($authManager->getRole('admin'), $authManager->getRole('simple'));

        // Дадим права администратора пользователю с id = 1
        $authManager->assign($authManager->getRole('admin'), 1);
    }
}
