<?php


namespace app\models;


use yii\base\Model;

/**
 * Class Activity
 * Отражает сущность события
 * @package app\models
 *
 * @property string|false $startTime
 * @property string|false $endTime
 */
class Activity extends Model
{
    /**
     * id сабытия
     * @var int
     */
    public $id;

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
    public $isRecurrent;

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
            'startDay' => 'Дата начала',
            'endDay' => 'Дата завершения',
            'idAuthor' => 'ID автора',
            'body' => 'Описание события',
            'isRecurrent' => 'Повторяющееся событие',
            'isAllDay' => 'Событие на весь день'
        ];
    }

    /**
     * Activity constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
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
        return date ("H:i", $timestamp);
    }

    /**
     * Возвращает дату начала события в виде ДД.ММ.ГГГГ
     * @return false|string
     */
    public function getStartDay()
    {
        return $this->getDay($this->startDay);
    }

    /**
     * Возвращает дату окончания события в виде ДД.ММ.ГГГГ
     * @return false|string
     */
    public function getEndDay()
    {
        return $this->getDay($this->endDay);
    }

    /**
     * Возвращает время начала события в виде ЧЧ:ММ
     * @return false|string
     */
    public function getStartTime()
    {
        return $this->getTime($this->startDay);
    }

    /**
     * Возвращает время завершения события в виде ЧЧ:ММ
     * @return false|string
     */
    public function getEndTime()
    {
        return $this->getTime($this->endDay);
    }

    /**
     * Правила валидации форм
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'startDay'], 'required'],
            [['id'], 'integer'],
//            [['startDay'], 'datetime', 'format' => 'php:d.m.Y H:i:s', 'timestampAttribute' => 'startDay'],
//            [['endDay'], 'datetime', 'format' => 'php:d.m.Y H:i:s', 'timestampAttribute' => 'endDay'],
            [['startDay', 'endDay'],'filter', 'filter' => function ($value){
                $dateTime = \DateTime::createFromFormat('php:d.m.Y H:i:s', $value);
                return $dateTime->format('U');
            }],
            [['body', 'endDay', 'idAuthor', 'isRecurrent', 'isAllDay'], 'safe']
        ];
    }
}