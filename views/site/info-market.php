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
        <div id="market-candle-container" data-symbol="<?= $symbol;?>"></div>
    </div>
</div>

<div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>

<div class="row">
    <div class="col-md-6">
        <h2 class="text-center">Volume <?= $symbol ?>/USD 24 by exchange </h2>
        <div id="volume-per-exchange" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

        <?php foreach ($modelsGroupByExchange as $model): ?>
            <div class="row">
                <div class="col-md-4"><h3><?= $model['exchange'] ?></h3></div>
                <div class="col-md-8">
                    <p><?= $model['market'] ?> ~  volume <?= $model['volume'] ?> $</p>
                    <p><?= $model['market'] ?> ~  price height <?= $model['high'] ?> $</p>
                    <p><?= $model['market'] ?> ~  price low <?= $model['low'] ?> $</p>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
    <div class="col-md-6">
        <h2 class="text-center">Volume <?= $symbol ?> 24 by currency</h2>
        <div id="market" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

        <?php foreach ($markets as $key => $market): ?>
            <div class="row">
                <div class="col-md-4"><h3><?= $key ?></h3></div>
                <div class="col-md-8">
                    <?php foreach ($market as $item): ?>
                        <div class="row">
                            <div class="col-md-4">
                                <p><?= $item['exchange'] ?></p>
                            </div>
                            <div class="col-md-8">
                                <p>
                                    <strong>Price high:</strong> <?= $item['high'] ?> $<br>
                                    <strong>Price low:</strong> <?= $item['low'] ?> $
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>

<?php   $this->registerJs("            
            Highcharts.chart('volume-per-exchange', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'percent',
                colorByPoint: true,
                data: [". $pieExchangeData ."]
            }]
        });
        
        Highcharts.chart('market', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: false
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                name: 'percent',
                colorByPoint: true,
                data: [". $pieMarketData ."]
            }]
        });
    ", yii\web\View::POS_READY);

?>

<?php $js = <<<JS
 $('.highcharts-range-selector-buttons .highcharts-button').on('click', function(){
     var tm = $(this).find('text').text();
     var symbol = $('#market-candle-container').attr('data-symbol');
     $.ajax({
            url: '/site/ajax-market-time-frame',
            type: 'POST',
            data: {"tm":tm, "symbol":symbol, "exchange":"all"},
            success: function(res){
                var obj = JSON.parse(res);
                console.log(obj.tickerList);
                console.log(obj.volumeList);
            },
            error: function(){
                alert('Error!');
            }
        });     
 
    return false;
 });
JS;

$this->registerJs($js);
