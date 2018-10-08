<?php

/**
*   @var $this yii\web\View
*   @var array $tickerList
*/

use \yii\helpers\VarDumper;

$this->title = 'Info '. $symbol;

?>

<div class="row">
    <h2><?= $symbol;?>-USD OHLV</h2>
    <div class="col-md-12">
        <div id="market-candle-container"></div>
    </div>
</div>


<?php //$this->registerJsFile('@web/js/site-info-market.js',[
        //'depens' => \app\assets\AppAsset::className(),
//]);

$this->registerJs("openCandleGraph('market-candle-container',". json_encode($tickerList) .");");
