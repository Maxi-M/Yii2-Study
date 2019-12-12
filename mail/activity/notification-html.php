<?php

/**
 * @var \app\models\Activity $activities []
 */

?>
<h1>Список активностей на сегодня</h1>
<table  style="mso-cellspacing: 0" ">
    <tr style="font-weight: bold">
    <td style="border: 1px solid #0f0f0f">Название события</td>
    <td style="border: 1px solid #0f0f0f">Дата начала</td>
    <td style="border: 1px solid #0f0f0f">Дата завершения</td>
    <td style="border: 1px solid #0f0f0f">Тест события</td>
    </tr>
<?php foreach ($activities as $activity): ?>
    <tr>
        <td style="border: 1px solid #0f0f0f"><?= $activity->title ?></td>
        <td style="border: 1px solid #0f0f0f"><?= $activity->startDay ?></td>
        <td style="border: 1px solid #0f0f0f"><?= $activity->endDay ?></td>
        <td style="border: 1px solid #0f0f0f"><?= $activity->body ?></td>
    </tr>
<?php endforeach; ?>
</table>

