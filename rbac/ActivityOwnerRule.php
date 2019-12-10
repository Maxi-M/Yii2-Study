<?php


namespace app\rbac;


use yii\rbac\Rule;

class ActivityOwnerRule extends Rule
{
    public $name = 'isActivityOwner';

    public function execute($user, $item, $params):bool
    {
        return isset($params['activity']) ? $params['activity']->id_author === $user : false;
    }
}