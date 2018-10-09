<?php
// _list_item.php
/**
 * @var $model []
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\State;
use  \app\models\Cctx;

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
        <a href="/site/info-market/<?= $currencySymbol . "?period=200%20DAY"; ?>">
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
    <td class="digital-td btc-td">
        <?= number_format($model['last']/Cctx::$BTC_CURRENT, 4); ?>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('0d', $currencySymbol)); ?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('0d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('0d', $currencySymbol)); ?>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('1d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=24h" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('1d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('1d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('7d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=7d" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('7d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('7d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('14d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=14%20DAY" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('14d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('14d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('30d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=30%20DAY" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('30d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('30d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('45d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=45%20DAY" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('45d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('45d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('90d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=90%20DAY" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('90d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('90d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="digital-td rnd-td bg-<?= State::getPercentGradation($model['last'], State::getAvgValue('200d', $currencySymbol)); ?>">
        <a href="<?= Url::to(["/site/info-market/".$currencySymbol ."?period=200%20DAY" ])?>">
        <?= State::hydratePercent($model['last'], State::getAvgValue('200d', $currencySymbol)); ?>
        <br>
        <?= State::hydrate(State::getAvgValue('200d', $currencySymbol)); ?>
        </a>
    </td>
    <td class="visual-td" data-target="modal-plot-container" data-id="plot-id" data-data="[<?= $thirtyDaysPlot; ?>]" data-columns="[<?=$thirtyDaysColumnsPlot?>]">
        <div id="container-<?= $model['id'];?>" class="chart7d"></div>
    </td>
</tr>

