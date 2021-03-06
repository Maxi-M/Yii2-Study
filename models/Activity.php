<?php


namespace app\models;

use app\components\behaviors\CacheBehavior;
use app\components\behaviors\TimestampTransformBehavior;
use DateTime;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Activity
 * Отражает сущность события
 * @package app\models
 * @property string $title [varchar(255)]
 * @property string $start_timestamp [MySQL timestamp]
 * @property string $end_timestamp [MySQL timestamp]
 * @property int $id_author [int(11)]
 * @property bool $is_recurrent [tinyint(1)]
 * @property bool $is_all_day [tinyint(1)]
 * @property int $id [int(11)]
 * @property string $body [text]
 * @property string|false $endTime
 * @property string|false $startTime
 * @property string|false $endDay
 * @property string|false $startDay
 * @property int $created_at [timestamp]
 * @property int $updated_at [timestamp]
 */
class Activity extends ActiveRecord
{
    /**
     * Возвращает название таблицы, так как оно не соответствует названию класса
     * @return string
     */
    public static function tableName(): string
    {
        return 'activities';
    }

    /**
     * Массив удобочитаемых названий атрибутов
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Название события',
            'start_timestamp' => 'Дата начала события',
            'end_timestamp' => 'Дата завершения события',
            'id_author' => 'ID автора',
            'body' => 'Описание события',
            'is_recurrent' => 'Повторяющееся событие',
            'is_all_day' => 'Событие на весь день'
        ];
    }

    /**
     * Правила валидации форм
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['start_timestamp'], 'required'],
            [['start_timestamp'], 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'start_timestamp'],
            [['end_timestamp'], 'date', 'format' => 'php:d.m.Y', 'timestampAttribute' => 'end_timestamp'],
            [['end_timestamp'], 'default', 'value' => strtotime($this->start_timestamp)],
            [['end_timestamp'], 'adjustDate'],
            [['id_author'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['id', 'is_recurrent', 'is_all_day'], 'safe']
        ];
    }

    /**
     * Функция-валидатор для проверки следующего правила следующими правилами.
     * - Дата окончания не может быть меньше даты начала.
     */
    public function adjustDate($attribute)
    {
        if ($this->start_timestamp > $this->end_timestamp) {
            $this->addError($attribute, 'Дата окончания события не может быть меньше даты начала события.');
        }
    }

    /**
     * Возвращает привязанные к модели поведения.
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'TimestampBehaviour' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'TimestampTransform' => [
                'class' => TimestampTransformBehavior::className(),
                'attributes' => ['start_timestamp', 'end_timestamp', 'created_at', 'updated_at'],
            ],
            CacheBehavior::class => [
                'class' => CacheBehavior::class,
                'cacheKey' => self::tableName(),
            ]
        ];
    }

    /**
     * Связь с таблицей пользователей
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_author']);
    }

    /**
     * Возвращает данные из кеша, или из базы, если кеширования не было.
     * @param mixed $condition
     * @return mixed|ActiveRecord|null
     */
    public static function findOne($condition)
    {
        $cacheKey = self::tableName().'_'.$condition;
        if (\Yii::$app->cache->exists($cacheKey) === false) {
            $result = parent::findOne($condition);
            \Yii::$app->cache->set($cacheKey, $result);
            return $result;
        }
        return \Yii::$app->cache->get($cacheKey);
    }

    /**
     * @param $timestamp - unix timestamp
     * @return false|string - строка в виде даты ДД.ММ.ГГГГ
     */
    protected function getDay($timestamp)
    {
        return date("d.m.Y", strtotime($timestamp));
    }

    /**
     * @param $timestamp - unix timestamp
     * @return false|string - строка в виде времени ЧЧ:ММ
     */
    protected function getTime($timestamp)
    {
        return date("H:i", strtotime($timestamp));
    }

    /**
     * Возвращает дату начала события в виде ДД.ММ.ГГГГ
     * @return false|string
     */
    public function getStartDay()
    {
        return $this->getDay($this->start_timestamp);
    }

    /**
     * Возвращает дату окончания события в виде ДД.ММ.ГГГГ
     * @return false|string
     */
    public function getEndDay()
    {
        return $this->getDay($this->end_timestamp);
    }

    /**
     * Возвращает время начала события в виде ЧЧ:ММ
     * @return false|string
     */
    public function getStartTime()
    {
        return $this->getTime($this->start_timestamp);
    }

    /**
     * Возвращает время завершения события в виде ЧЧ:ММ
     * @return false|string
     */
    public function getEndTime()
    {
        return $this->getTime($this->end_timestamp);
    }


}