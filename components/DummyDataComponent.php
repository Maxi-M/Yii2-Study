<?php


namespace app\components;


use app\models\Activity;
use yii\base\Component;

class DummyDataComponent extends Component
{
    /**
     * Содержит массив событий.
     * @var Activity[]
     */
    public $activities;

    public function init()
    {
        parent::init();
        // Генерим данные
        $this->fillActivities();
    }

    /**
     * Заполняет свойство $activities некоторыми данными
     */
    private function fillActivities()
    {
        $initialTime = time();
        $oneHour = 60 * 60;
        $oneDay = $oneHour * 24;
        $oneWeek = $oneDay * 7;

        $this->activities[] = new Activity([
            'id' => 0,
            'title'=>'Какая-то активность №1',
            'startDay' => $initialTime,
            'endDay' => $initialTime,
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae eum explicabo maxime porro qui recusandae sunt! Assumenda distinctio eaque voluptatibus.',
            'isRecurrent' =>true,
            'isAllDay' => true,
        ]);
        $this->activities[] = new Activity([
            'id' => 1,
            'title'=>'Какая-то активность №2',
            'startDay' => $initialTime + $oneDay * 3,
            'endDay' => $initialTime + $oneDay * 4,
            'body' => 'A, aliquid aperiam culpa dignissimos dolorem dolorum ducimus facere fugit harum mollitia natus nobis nostrum, odio provident quam reprehenderit similique tempora voluptatibus.',
            'isRecurrent' =>false,
            'isAllDay' => false,
        ]);
        $this->activities[] = new Activity([
            'id' => 2,
            'title'=>'Какая-то активность №3',
            'startDay' => $initialTime + $oneDay * 10 + $oneHour * 3,
            'endDay' => $initialTime + $oneDay * 10 + $oneHour * 5,
            'body' => 'Accusamus ad architecto aspernatur blanditiis cum cumque cupiditate debitis dolorem ea est laborum maxime, molestiae molestias pariatur perspiciatis quaerat rem, sapiente sequi unde voluptatum! Adipisci animi at beatae cumque optio quos sapiente sequi voluptate? Animi dolore eligendi expedita ipsam praesentium, quo sed sit ullam vel, veniam, veritatis vero vitae voluptates.',
        ]);
    }
}