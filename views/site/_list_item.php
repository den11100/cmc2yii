<?php
// _list_item.php
/**
 * @var $model []
 * @var $this \yii\web\View
 * @var integer $bitcoinPrice
 */

use app\models\State;

$currencySymbol = $model['symbol'];

$sevenDaysPlot = implode(', ', [
    (float)State::getAvgValue('1d', $currencySymbol),
    (float)State::getAvgValue('2d', $currencySymbol),
    (float)State::getAvgValue('3d', $currencySymbol),
    (float)State::getAvgValue('4d', $currencySymbol),
    (float)State::getAvgValue('5d', $currencySymbol),
    (float)State::getAvgValue('6d', $currencySymbol),
    (float)State::getAvgValue('7d', $currencySymbol),
]);

$this->registerJs("openGraph('container-".$model['id']."', [".$sevenDaysPlot."]);");

?>
<tr>
    <!--<td class="digital-td">
        <?/*= $model['id']; */?>
    </td>-->
    <td class="digital-td name-td">
        <a href="/site/info-market/<?= $currencySymbol ?>">
            <?php if (file_exists(__DIR__ . '/../../web/icons/' . strtolower($currencySymbol) . '.png')) { ?>
                <img src="/icons/<?= strtolower($currencySymbol); ?>.png" class="icon" alt="<?= $currencySymbol; ?>">
            <?php } ?>
            <?= $model['name']; ?>
        </a>
    </td>
    <td class="digital-td">
        <?= $currencySymbol; ?>
    </td>
    <td class="digital-td">
        <?php if ($model['price'] > 1): ?>
            <?= '$ '.number_format($model['price'],2); ?>
        <?php else: ?>
            <?= '$ '.number_format($model['price'],4); ?>
        <?php endif; ?>
    </td>
    <td class="digital-td text-small">
        <?= '$ '.number_format($model['market_cap'],0) ?>
    </td>
    <td class="digital-td text-small">
        <?= number_format($model['circulating_supply'],0) ?>
    </td>
    <td class="digital-td btc-td">
        <?= number_format($model['price']/$bitcoinPrice, 5); ?>
    </td>
    <td class="digital-td visual-td-ajax rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('1h', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-interval="1m" data-symbol="<?=$currencySymbol?>" data-chart="1 HOUR">
        <?= State::hydratePercent($model['price'], State::getAvgValue('1h', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('1h', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td-ajax rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('4h', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-interval="1m" data-symbol="<?=$currencySymbol?>" data-chart="4 HOUR">
        <?= State::hydratePercent($model['price'], State::getAvgValue('4h', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('4h', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td-ajax rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('1d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-interval="1m" data-symbol="<?=$currencySymbol?>" data-chart="1 DAY">

        <?= State::hydratePercent($model['price'], State::getAvgValue('1d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('1d', $currencySymbol)); ?>

    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('7d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,7); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,7);?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('7d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('7d', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('14d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,14); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,14);?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('14d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('14d', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('30d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,30); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,30);?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('30d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('30d', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('45d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,45); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,45);?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('45d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('45d', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('90d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,90); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,90);?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('90d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('90d', $currencySymbol)); ?>
    </td>
    <td class="digital-td visual-td rnd-td bg-<?= State::getPercentGradation($model['price'], State::getAvgValue('200d', $currencySymbol)); ?>" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,200); ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,200)?>]">
        <?= State::hydratePercent($model['price'], State::getAvgValue('200d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('200d', $currencySymbol)); ?>
    </td>
    <td class="visual-td" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= State::getDataPrice($currencySymbol,30) ?>]" data-columns="[<?=State::getDataVolume($currencySymbol,30);?>]">
        <div id="container-<?= $model['id'];?>" class="chart7d"></div>
    </td>
</tr>

