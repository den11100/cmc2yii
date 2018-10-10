<?php

/**
 * @var $this yii\web\View
 * @var $dataProvider \yii\data\ArrayDataProvider
 * @var array $marketCapFinal
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
                                <!--<th>#</th>-->
                                <th>Name</th>
                                <th>Symbol</th>
                                <th>Price</th>
                                <th>Market Cap</th>
                                <th>BTC</th>
                                <th>1h</th>
                                <th>24h</th>
                                <th>7d</th>
                                <th>14d</th>
                                <th>30d</th>
                                <th>45d</th>
                                <th>90d</th>
                                <th>200d</th>
                                <th>7 days chart</th>
                            </tr>                        
                        </thead>
                        <tbody>
                        {items}
                        </tbody>
                        </table>
                        <div class="pager-div">{pager}</div>',
            'itemView' => '_list_item',
            'viewParams' => ['marketCapFinal' => $marketCapFinal],
        ]); ?>

    </div>
</div>
