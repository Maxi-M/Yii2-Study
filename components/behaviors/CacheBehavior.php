<?php


namespace app\components\behaviors;


use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CacheBehavior extends Behavior
{
    /**
     * @var string
     */
    public $cacheKey;

    /**
     * События, на которые срабатывает поведение
     * @return array
     */
    public function events():array
    {
        return [
                ActiveRecord::EVENT_AFTER_INSERT => 'deleteCache',
                ActiveRecord::EVENT_AFTER_UPDATE => 'deleteCache',
                ActiveRecord::EVENT_AFTER_DELETE => 'deleteCache',
        ];
    }

    /**
     * Удаляет данные из кеша по ключу
     */
    public function deleteCache():void
    {
        \Yii::$app->cache->delete($this->cacheKey.'_'.$this->owner->getPrimaryKey());
    }
}