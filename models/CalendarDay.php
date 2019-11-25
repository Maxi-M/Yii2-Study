<?php


namespace app\models;


use yii\base\Model;

/**
 * Class CalendarDay
 * Представляет собой сущность календарного дня
 * @package app\models
 */
class CalendarDay extends Model
{
    public $isHoliday;

    public $date;

    /**
     * Возвращает массив событий, относящихся к дате
     * @return Activity[];
     */
    public function getActivities() {
        // Получить список событий, чьи дата начала и конца перекрывают дату ($date) календарного дня
        return [];
    }

}