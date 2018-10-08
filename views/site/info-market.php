<?php

/**
 * @var $this yii\web\View
 * @var array $tickerList
 * @var $symbol string
 * @var $volumeList array
*/

use \yii\helpers\VarDumper;

$this->title = 'Info '. $symbol;

$this->registerJs("openCandleGraph('market-candle-container',". json_encode($tickerList) .", '$symbol', ".json_encode($volumeList)." );");
?>

<div class="row">
    <h2><?= $symbol;?>-USD OHLV</h2>
    <div class="col-md-12">
        <div id="market-candle-container"></div>
    </div>
</div>

