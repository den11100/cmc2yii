<?php

/**
 * @var $this yii\web\View
 * @var array $listLeadersGrow
 * @var array $listLeadersFall
 */

$this->title = 'Лидеры падения и роста';

?>

<div class="row">
    <div class="col-md-5">
        <h2>Лидеры роста</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Монета</th>
                    <th>Предыдущая стоимость</th>
                    <th>Средняя стоимость</th>
                    <th>Процент</th>
                    <th>Пред. объём торгов, M</th>
                    <th>Объём торгов, M</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listLeadersGrow as $key => $item): ?>
                    <tr>
                        <td><?= $key ?></td>
                        <td><?= round($item['avg_price_old'], 6) ?>$ </td>
                        <td><?= round($item['avg_price'], 6) ?>$ </td>
                        <td><?= round($item['avg_subtraction_price_percent'],2) ?>%</td>
                        <td><?= round($item['volume'],6) ?></td>
                        <td><?= round($item['volume_old'],6) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-5">
        <h2>Лидеры падения</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Монета</th>
                <th>Предыдущая стоимость</th>
                <th>Средняя стоимость</th>
                <th>Процент</th>
                <th>Пред. объём торгов, M</th>
                <th>Объём торгов, M</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listLeadersFall as $key => $item): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= round($item['avg_price_old'], 6) ?>$ </td>
                    <td><?= round($item['avg_price'], 6) ?>$ </td>
                    <td><?= round($item['avg_subtraction_price_percent'],2) ?>%</td>
                    <td><?= round($item['volume'],6) ?></td>
                    <td><?= round($item['volume_old'],6) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
