<?php


namespace app\models;

use DateTime;
use yii\db\ActiveRecord;

/**
 * Class Activity
 * Отражает сущность события
 * @package app\models
 * @property int $start_timestamp [timestamp]
 * @property int $end_timestamp [timestamp]
 * @property int $id_author [int(11)]
 * @property bool $is_recurrent [tinyint(1)]
 * @property bool $is_all_day [tinyint(1)]
 * @property int $id [int(11)]
 * @property string $title [varchar(255)]
 * @property string|false $endTime
 * @property string|false $startTime
 * @property string|false $endDay
 * @property string|false $startDay
 * @property string $body [text]
 */
class Activity extends ActiveRecord
{
    /**
     * Возвращает название таблицы, так как оно не соответствует названию класса
     * @return string
     */
    public static function tableName()
    {
        return 'activities';
    }

    /**
     * Массив удобочитаемых названий атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название события',
            'start_timestamp' => 'Время начала события',
            'end_timestamp' => 'Время завершения события',
            'id_author' => 'ID автора',
            'body' => 'Описание события',
            'is_recurrent' => 'Повторяющееся событие',
            'is_all_day' => 'Событие на весь день'
        ];
    }

    /**
     * @param $timestamp - unix timestamp
     * @return false|string - строка в виде даты ДД.ММ.ГГГГ
     */
    protected function getDay($timestamp)
    {
        return date("d.m.Y", $timestamp);
    }

    /**
     * @param $timestamp - unix timestamp
     * @return false|string - строка в виде времени ЧЧ:ММ
     */
    protected function getTime($timestamp)
    {
        return date("H:i", $timestamp);
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

    /**
     * Правила валидации форм
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'start_timestamp'], 'required'],
            [['id'], 'integer'],
//            [['startDay'], 'datetime', 'format' => 'php:d.m.Y H:i:s', 'timestampAttribute' => 'startDay'],
//            [['endDay'], 'datetime', 'format' => 'php:d.m.Y H:i:s', 'timestampAttribute' => 'endDay'],
            [['start_timestamp', 'end_timestamp'], 'filter', 'filter' => function ($value) {
                $dateTime = DateTime::createFromFormat('php:d.m.Y H:i:s', $value);
                return $dateTime->format('U');
            }],
            [['body', 'end_timestamp', 'id_author', 'is_recurrent', 'is_all_day'], 'safe']
        ];
    }
}