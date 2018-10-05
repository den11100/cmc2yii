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
            <?php if ($listLeadersGrow != []): ?>
                <tbody>
                    <?php foreach ($listLeadersGrow as $key => $item): ?>
                        <?php $currencies = explode('/', $key);?>
                        <?php $currencyOne = $currencies[0];?>
                        <?php $currencyTwo = $currencies[1];?>
                        <tr>
                            <td>
                                <a href="/site/info-pair/<?= $currencyOne;?>">
                                    <?=$currencyOne; ?>
                                </a>
                                /
                                <a href="/site/info-pair/<?= $currencyTwo; ?>">
                                    <?=$currencyTwo; ?>
                                </a>
                            </td>
                            <td><?= round($item['avg_price_old'], 6) ?>$ </td>
                            <td><?= round($item['avg_price'], 6) ?>$ </td>
                            <td><?= round($item['avg_subtraction_price_percent'],2) ?>%</td>
                            <td><?= round($item['volume'],6) ?></td>
                            <td><?= round($item['volume_old'],6) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php endif ?>
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
            <?php if ($listLeadersFall != []): ?>
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
            <?php endif ?>
        </table>
    </div>
</div>
