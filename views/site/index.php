<?php

/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ArrayDataProvider
 * @var $finalModels \app\models\MarketCap
 * @var integer $bitcoinPrice
 */

$this->title = 'CMC2';

?>
<div class="site-index">

    <div class="body-content">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '<table class="main-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Symbol</th>
                                <th>Price</th>
                                <th>BTC</th>
                                <th>Mkt. Cap</th>
                                <th>Circ. Supply</th>
                                <th>4h</th>
                                <th>24h</th>
                                <th>7d</th>
                                <th>14d</th>
                                <th>30d</th>
                                <th>45d</th>
                                <th>90d</th>
                                <th>200d</th>
                                <th class="th-chart">7 days chart</th>
                            </tr>                        
                        </thead>
                        <tbody>
                        {items}
                        </tbody>
                        </table>
                        <div class="pager-div">{pager}</div>',
            'itemView' => '_list_item',
            'viewParams' => ['bitcoinPrice' => $bitcoinPrice],
        ]); ?>

    </div>
</div>
