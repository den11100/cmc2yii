<?php
// _list_item.php
/**
 * @var $model []
 * @var $this \yii\web\View
 * @var array $marketCapFinal
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\State;
use  \app\models\Cctx;
use yii\helpers\ArrayHelper;

$currencySymbol = str_replace(['/USDT', '/USDC', '/USD'], '', $model['symbol']);
$currencies = \yii\helpers\Json::decode(Yii::$app->params['currencies']);
$currencyName = !empty($currencies[$currencySymbol]) ?
    $currencies[$currencySymbol] : $currencySymbol;


$sevenDaysPlot = implode(', ', [
    (float)State::getAvgValue('1d', $currencySymbol),
    (float)State::getAvgValue('2d', $currencySymbol),
    (float)State::getAvgValue('3d', $currencySymbol),
    (float)State::getAvgValue('4d', $currencySymbol),
    (float)State::getAvgValue('5d', $currencySymbol),
    (float)State::getAvgValue('6d', $currencySymbol),
    (float)State::getAvgValue('7d', $currencySymbol),
]);

$thirtyDaysPlot = [];
for($i = 0; $i <= 30; $i++)
{
    $thirtyDaysPlot[] = (float)State::getAvgValue($i.'d', $currencySymbol);
}
$thirtyDaysPlot = implode(',', $thirtyDaysPlot);


$thirtyDaysColumnsPlot = [];
for($i = 0; $i <= 30; $i++)
{
    $thirtyDaysColumnsPlot[] = (float)State::getVolume($i.'d', $currencySymbol);
}
$thirtyDaysColumnsPlot = implode(',', $thirtyDaysColumnsPlot);


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
            <?= $currencyName; ?>
        </a>
    </td>
    <td class="digital-td">
        <?= $currencySymbol; ?>
    </td>
    <td class="digital-td">
        <?= '$ '.number_format($model['last'], 4); ?>
    </td>
    <td class="digital-td">
        <?= ArrayHelper::getValue($marketCapFinal, $currencySymbol) ?>
    </td>
    <td class="digital-td btc-td">
        <?= number_format($model['last']/Cctx::$BTC_CURRENT, 4); ?>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('0d', $currencySymbol)); ?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('0d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('0d', $currencySymbol)); ?>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('1d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('1d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('1d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('7d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('7d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('7d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('14d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('14d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('14d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('30d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('30d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('30d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('45d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('45d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('45d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('90d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('90d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('90d', $currencySymbol)); ?>

    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('200d', $currencySymbol)); ?>">

        <?= State::hydratePercent($model['last'], State::getAvgValue('200d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('200d', $currencySymbol)); ?>

    </td>
    <td class="visual-td" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= $thirtyDaysPlot; ?>]" data-columns="[<?=$thirtyDaysColumnsPlot?>]">
        <div id="container-<?= $model['id'];?>" class="chart7d"></div>
    </td>
</tr>

