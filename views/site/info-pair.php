<?php

/**
 * @var $this yii\web\View
 * @var $modelsGroupByExchange \app\models\State[]
 * @var string $symbol
 * @var string $pieExchangeData
 */

$this->title = 'Круговая диаграмма обьём торго монеты за 24 часа по биржам';

?>

<div class="site-volume-per-exchange">

    <div class="row">
        <div class="col-md-6">
            <h2>Суммарный обьём торгов <?= $symbol ?>/USD разбивка по биржам за 24 часа</h2>
            <div id="volume-per-exchange" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            <?php
                echo "<pre style='font-size: 10px'>";
                print_r($modelsGroupByExchange);
                echo "</pre>";
            ?>
        </div>
        <div class="col-md-6">
            <h2>Суммарный обьём торгов на всех биржах за 24 часа разбивка по валютным парам</h2>
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
    ", yii\web\View::POS_READY);
