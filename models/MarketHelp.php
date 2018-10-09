<?php
/**
 * User: dn
 * Date: 09.10.18
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


class MarketHelp extends Model
{
    /**
     * Получаем data and volume (данные поступают из ajax запроса) для построения графика OHLV + volume с помощью js
     * @param string $tm
     * @param string $symbol
     * @param string $exchange
     * @return array
     */
    public static function getLists($tm, $symbol, $exchange)
    {
        $t = "";
        $period = "";
        switch ($tm) {
            case "1h":
                $t = "5m";
                $period = "24 HOUR";
                break;
            case "4h":
                $t = "5m";
                $period = "48 HOUR";
                break;
            case "24h":
                $t = "15m";
                $period = "1 DAY";
                break;
            case "7d":
                $t = "1h";
                $period = "14 DAY";
                break;
            case "14d":
                $t = "1h";
                $period = "30 DAY";
                break;
            case "30d":
                $t = "1d";
                $period = "200 DAY";
                break;
            case "45d":
                $t = "1d";
                $period = "200 DAY";
                break;
            case "90d":
                $t = "1d";
                $period = "200 DAY";
                break;
            case "200d":
                $t = "1d";
                $period = "200 DAY";
                break;
        }

        if($t == ''){
            return 'none';
        }

        if ($exchange == 'all') {
            /* находим id записей максимально близкие к now */
            $array = State::find()
                ->where(new Expression('timestamp BETWEEN UNIX_TIMESTAMP(NOW() - INTERVAL '.$period.')*1000 AND UNIX_TIMESTAMP(NOW())*1000'))
                ->andWhere(['interval' => $t])
                ->andWhere(['market' => $symbol.'/USDT'])
                ->orderBy('timestamp asc')
                ->asArray()
                ->all();
        } else {
            /* находим id записей максимально близкие к now */
            $array = State::find()
                ->where(new Expression('timestamp BETWEEN UNIX_TIMESTAMP(NOW() - INTERVAL '.$period.')*1000 AND UNIX_TIMESTAMP(NOW())*1000'))
                ->andWhere(['interval' => $t])
                ->andWhere(['market' => $symbol.'/USDT'])
                ->andWhere(['exchange' => $exchange])
                ->orderBy('timestamp asc')
                ->asArray()
                ->all();
        }

        $idRowTimestampLessToNow = ArrayHelper::getColumn($array,'id');
        $list = State::find()
            ->select('timestamp, avg(open) as avg_open, avg(high) as avg_high, avg(low) as avg_low,  avg(close) as avg_close, volume')
            ->where(['in', 'id', $idRowTimestampLessToNow])
            ->asArray()
            ->groupBy('timestamp')
            ->all();

        $tickerList = [];
        $volumeList = [];
        foreach ($list as $key => $item) {
            $itemNumbers = [];
            $volumeNumbers = [];
            foreach ($item as $k => $value){
                if ($k == 'volume' || $k == 'timestamp'){
                    $volumeNumbers[$k] = $value*1;
                }
                if ($k != 'volume') {
                    $itemNumbers[$k] = $value*1;
                }
            }
            $tickerList[$key] = array_values($itemNumbers);
            $volumeList[$key] = array_values($volumeNumbers);
        }

        return ["tickerList" => $tickerList, "volumeList" => $volumeList];
    }

    /**
     * функция для построения пирога Volume per exchange for 24h
     * @param string $symbol
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getListForPieExchange($symbol)
    {
        $result = Yii::$app->db->createCommand('SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS id FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY exchange) AS z2 
            ON (z1.id = z2.id)
            ')->bindValue(':symbol', $symbol . '/USD%')
            ->queryAll();
        return $result;
    }

    /**
     * функция для построения пирога Volume per exchange for 24h
     * @param array $modelsGroupByExchange
     * @return string
     */
    public static function getPieExchangeData($modelsGroupByExchange)
    {
        $result = '';
        if ($modelsGroupByExchange != []) {
            /* добавляем в массив моделей в каждую модель свойство percent */
            $modelsGroupByExchange = self::getPercent($modelsGroupByExchange);

            //{name:'ACX', y:0.1767}, {name:'Binance', y:0.2744}, {name:'HitBTC', y:0.5488}
            foreach ($modelsGroupByExchange as $model) {
                $result .= '{name:\'' . $model['exchange'] . '\',y:' . $model['percent']. '},';
            }
        }
        return $result;
    }

    /**
     * функция для пирога Volume (BTC or ETH or DASH) for 24h group by currency
     * @param string $symbol
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getModelsGroupByMarket($symbol)
    {
        $result = Yii::$app->db->createCommand('SELECT SUM(volume) as volume, market FROM (
            SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS ids FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY market, exchange) AS z2 
            ON (z1.id = z2.ids)) AS x GROUP BY market
            ')->bindValue(':symbol', $symbol .'/%')
            ->queryAll();
        return $result;
    }

    /**
     * функция для пирога Volume (BTC or ETH or DASH) for 24h group by currency
     * @param string $symbol
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getModelsGroupByMarketWithExchange($symbol)
    {
        $result = Yii::$app->db->createCommand('
            SELECT * FROM {{%state}} z1  
            INNER JOIN (SELECT MAX(id) AS ids FROM {{%state}} WHERE market LIKE :symbol AND `interval` = "1d" GROUP BY market, exchange) AS z2 
            ON (z1.id = z2.ids)
            ')->bindValue(':symbol', $symbol .'/%')
            ->queryAll();
        return $result;
    }

    /**
     * функция для пирога Volume (BTC or ETH or DASH) for 24h group by currency
     * @param array $modelsGroupByMarketWithExchange
     * @return array
     */
    public static function getMarkets($modelsGroupByMarketWithExchange)
    {
        $markets = [];
        if($modelsGroupByMarketWithExchange != []) {
            foreach ($modelsGroupByMarketWithExchange as $key => $item) {
                $markets[$item['market']][$key]['high'] = $item['high'];
                $markets[$item['market']][$key]['low'] = $item['low'];
                $markets[$item['market']][$key]['volume'] = $item['volume'];
                $markets[$item['market']][$key]['market'] = $item['market'];
                $markets[$item['market']][$key]['exchange'] = $item['exchange'];
                $markets[$item['market']][$key]['timestamp'] = $item['timestamp'];
                $markets[$item['market']][$key]['interval'] = $item['interval'];
            }
            //VarDumper::dump($modelsGroupByMarketWithExchange,7,1);
            //VarDumper::dump($result,7,1);die;
        }
        return $markets;
    }

    /**
     * функция для пирога Volume (BTC or ETH or DASH) for 24h group by currency
     * @param array $modelsGroupByMarket
     * @return string
     */
    public static function getPieMarketData($modelsGroupByMarket)
    {
        $pieMarketData = '';
        if ($modelsGroupByMarket != []) {
            /* добавляем в массив моделей в каждую модель свойство percent */
            $modelsGroupByMarket = self::getPercent($modelsGroupByMarket);

            //{name:'BTC/USD', y:0.1767}, {name:'BTC/USDT', y:0.2744}, {name:'BTC/USDC', y:0.5488}
            foreach ($modelsGroupByMarket as $model) {
                $pieMarketData .= '{name:\'' . $model['market'] . '\',y:' . $model['percent']. '},';
            }
        }
        return $pieMarketData;
    }

    /**
     * добавляет в модель значение в %
     * @param $models
     * @return mixed
     */
    private static function getPercent($models)
    {
        if($models != []) {
            $sum = array_sum(ArrayHelper::getColumn($models, 'volume'));
            foreach ($models as $key => $model) {
                //$models[$key]['volume'] = round($model['volume'], 4);
                $models[$key]['percent'] = round($model['volume'] / $sum, 4);
            }
        }
        return $models;
    }


} // end class
