<?php

/**
 * @var $this yii\web\View
 * @var array $listLeadersGrow
 * @var array $listLeadersFall
 */

$this->title = 'Leaders';

?>

<div class="row">
    <div class="col-md-5">
        <h2>Grow leaders</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Currency</th>
                    <th>Last price</th>
                    <th>Avg. price</th>
                    <th>Percent</th>
                    <th>Volume, M</th>
                    <th>Volume old, M</th>
                </tr>
            </thead>
            <?php if ($listLeadersGrow != []): ?>
                <tbody>
                    <?php foreach ($listLeadersGrow as $key => $item): ?>
                        <?php $currencies = explode('/', $key);?>
                        <?php $currencyOne = $currencies[0];?>
                        <?php $currencyTwo = $currencies[1];?>
                        <tr>
                            <td style="width: 300px; min-width: 300px;">
                                <a href="/site/info-market/<?= $currencyOne;?>">
                                    <?=$currencyOne; ?>
                                </a>/ <?=$currencyTwo; ?>
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
    <div class="col-md-5" style="margin-left: 5%;">
        <h2>Fall leaders</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Currency</th>
                <th>Last price</th>
                <th>Avg. price</th>
                <th>Percent</th>
                <th>Volume, M</th>
                <th>Volume old, M</th>
            </tr>
            </thead>
            <?php if ($listLeadersFall != []): ?>
                <tbody>
                <?php foreach ($listLeadersFall as $key => $item): ?>
                    <tr>
                        <?php $currencies = explode('/', $key);?>
                        <?php $currencyOne = $currencies[0];?>
                        <?php $currencyTwo = $currencies[1];?>
                        <td style="width: 300px; min-width: 300px;">
                            <a href="/site/info-pair/<?= $currencyOne;?>">
                                <?=$currencyOne; ?>
                            </a>/ <?=$currencyTwo; ?>
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
</div>
