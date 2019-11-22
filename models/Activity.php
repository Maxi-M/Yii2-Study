<?php


namespace app\models;


use yii\base\Model;

/**
 * Class Activity
 * Отражает сущность события
 * @package app\models
 */
class Activity extends Model
{
    /**
     * Название (заголовок) события
     * @var string
     */
    public $title;

    /**
     * Unix timestamp дня начала события
     * @var int
     */
    public $startDay;

    /**
     * Unix timestamp дня окончания события
     * @var int
     */
    public $endDay;

    /**
     * ID автора, пользователя, создавшего событие
     * @var int
     */
    public $idAuthor;

    /**
     * Описание события
     * @var string
     */
    public $body;

    /**
     * Признак повторяющегося события
     * @var bool
     */
    public $isRequrrent;

    /**
     * Признак того, что событие занимает весь день.
     * @var bool
     */
    public $isAllDay;

    /**
     * Массив удобочитаемых названий атрибутов
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название события',
            'startDate' => 'Дата начала',
            'endDate' => 'Дата завершения',
            'idAuthor' => 'ID автора',
            'body' => 'Описание события',
            'isRequrrent' => 'Повторяющееся событие',
            'isAllDay' => 'Событие на весь день'
        ];
    }
}