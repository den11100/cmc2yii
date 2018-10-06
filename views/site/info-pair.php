<?php

/**
 * @var $this yii\web\View
 * @var array $modelsGroupByExchange
 * @var array $modelsGroupByMarket
 * @var array $markets
 * @var string $symbol
 * @var string $pieExchangeData
 * @var string $pieMarketData
 */

$this->title = 'Volume 24 by exchange';

?>

<div class="site-volume-per-exchange">

    <div class="row">
        <div class="col-md-6">
            <h2>Volume <?= $symbol ?>/USD 24 by exchange </h2>
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
            <h2>Volume <?= $symbol ?> 24 by currency</h2>
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
                                <p><strong>Price height:</strong> <?= $item['high'] ?> $<br>
                                    <strong>Price low:</strong> <?= $item['low'] ?> $</p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
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
                text: 'Volume per exchange for 24h'
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
                text: 'Market for 24h'
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
