<?php

/**
 * @var $this yii\web\View
 * @var array $modelsGroupByExchange
 * @var array $modelsGroupByMarket
 * @var array $modelsGroupByMarketWithExchange
 * @var string $symbol
 * @var string $pieExchangeData
 * @var string $pieMarketData
 */

$this->title = 'Круговая диаграмма обьём торго монеты за 24 часа по биржам';

?>

<div class="site-volume-per-exchange">

    <div class="row">
        <div class="col-md-6">
            <h2>Суммарный обьём торгов <?= $symbol ?>/USD разбивка по биржам за 24 часа</h2>
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


            <?php
                echo "<pre style='font-size: 10px'>";
                print_r($modelsGroupByExchange);
                echo "</pre>";
            ?>
        </div>
        <div class="col-md-6">
            <h2>Суммарный обьём торгов <?= $symbol ?> на всех биржах за 24 часа разбивка по валютам</h2>
            <div id="market" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

            <?php foreach ($modelsGroupByMarketWithExchange as $model): ?>
                <div class="row">
                    <div class="col-md-4"><h3><?= $model['market'] ?></h3></div>
                    <div class="col-md-8">
                        <p><?= $model['exchange'] ?> price height <?= $model['high'] ?> $  | price low <?= $model['low'] ?> $</p>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>

            <?php
                echo "<pre style='font-size: 10px'>";
                print_r($modelsGroupByMarket);
                echo "</pre>";
            ?>
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
                data: [". $pieMarketData ."]
            }]
        });
    ", yii\web\View::POS_READY);
