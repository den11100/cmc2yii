<?php

/**
*   @var $this yii\web\View*
*/

use \yii\helpers\VarDumper;

$this->title = 'Info '. $symbol;

?>

<div class="site-volume-per-exchange">

    <div class="row">
        <h2><?= $symbol;?>-USD OHLV</h2>
        <div class="col-md-12">
            <div id="container-<?= $symbol;?>" class="chart7d"></div>
        </div>
    </div>

</div>