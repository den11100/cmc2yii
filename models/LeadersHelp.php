<?php
/**
 * Created by PhpStorm.
 * User: dn
 * Date: 03.10.18
 * Time: 6:10
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


class LeadersHelp extends Model
{
    /**
     * Получаем массив лидеров падения и роста
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getLeaders()
    {
        /* находим id записей максимально близкие к now группируем по market и exchange*/
        $array = State::find()
            ->select('max(id) as max_id')
            ->where(new Expression('timestamp BETWEEN UNIX_TIMESTAMP(NOW() - INTERVAL 2 DAY)*1000 AND UNIX_TIMESTAMP(NOW())*1000'))
            ->andWhere(['interval' => '1d'])
            ->groupBy('market, exchange')
            ->orderBy('max_id asc')
            ->asArray()
            ->all();
        //VarDumper::dump($array, 7, 1);
        $idRowTimestampLessToNow = ArrayHelper::getColumn($array,'max_id');

        $list = State::find()
            ->where(['in', 'id', $idRowTimestampLessToNow])
            ->asArray()
            ->all();
        //VarDumper::dump($list, 7, 1);
        $resultListGroupByMarketAndExchange = self::prepareDataLeadersGrow($list);
        $resultListGroupByMarketAndExchange = self::cleanListLeaders($resultListGroupByMarketAndExchange); // Убираем строки в которых нет предыдущих значений по времени

        return $resultListGroupByMarketAndExchange;
    }

    /**
     * Добавляем в массив - предыдущие значения для каждой валютной пары
     * если предыдущего значения не находим - записываем 'is_have_data' => false
     * [
            'id' => '27180'
            'high' => '221.99957157'
            'low' => '221.99957157'
            'volume' => '0.00488514'
            'market' => 'ETH/USDC'
            'exchange' => 'Poloniex'
            'timestamp' => '1538697600000'
            'interval' => '1d'
            'is_have_data' => true
            'old_id' => '13567'
            'old_timestamp' => '1538611200000'
            'old_volume' => '108.30724496'
            'old_avg_price' => 221.56969405
            'now_avg_price' => 221.99957157
            'subtraction_price' => 0.42987752
            'subtraction_price_percent' => 0.194
        ]
     * @param array $list
     * @return array
     * @throws \yii\db\Exception
     */
    private static function prepareDataLeadersGrow($list)
    {
        foreach ($list as $key => $item) {
            $beforeDay = $item['timestamp']/1000 - 60*60*24;
            $row = Yii::$app->db->createCommand("
                SELECT * FROM {{%state}} 
                WHERE `interval` = '1d' 
                AND `market` = '{$item['market']}'
                AND `exchange` = '{$item['exchange']}'
                AND `timestamp` = $beforeDay*1000
            ")->queryOne();

            if ($row != []) {
                $list[$key]['is_have_data'] = true;
                $list[$key]['old_id'] = $row['id'];
                $list[$key]['old_timestamp'] = $row['timestamp'];
                $list[$key]['old_volume'] = $row['volume'];
                $list[$key]['old_avg_price'] = round(($row['high'] + $row['low']) / 2, 9);
                $list[$key]['now_avg_price'] = round(($item['high'] + $item['low']) / 2,9);
                $list[$key]['subtraction_price'] = round( $list[$key]['now_avg_price'] - $list[$key]['old_avg_price'], 9);
                $list[$key]['subtraction_price_percent'] = round(($list[$key]['subtraction_price'] / $list[$key]['old_avg_price']) * 100, 3);
            } else {
                $list[$key]['is_have_data'] = false;
            }
        }
        return $list;
    } // end method

    /**
     * @param array $list
     * @return array
     */
    private static function cleanListLeaders($list)
    {
        foreach ($list as $key => $item) {
            if ($item['is_have_data'] == false) {
                unset($list[$key]);
            }
        }
        return $list;
    } // end method


    public static function getLeadersGrow($listLeaders, $number)
    {
        $resultList = self::makeListLeadersUpOrDown($listLeaders, 'up');
        $resultListGrouped = self::groupedByMarkets($resultList);
        //TODO доделать Количество отображаемых лидеров роста $number
        return $resultListGrouped;
    }

    public static function getLeadersFall($listLeaders, $number)
    {
        $resultList = self::makeListLeadersUpOrDown($listLeaders, 'down');
        $resultListGrouped = self::groupedByMarkets($resultList);
        //TODO доделать Количество отображаемых лидеров падения $number
        return $resultListGrouped;
    }

    /**
     * @param array $listLeaders
     * @param string $type
     * @return array
     */
    private static function makeListLeadersUpOrDown($listLeaders, $type)
    {
        if ($type == 'up') {
            foreach ($listLeaders as $key => $item) {
                if ($item['subtraction_price'] < 0) {
                    unset($listLeaders[$key]);
                }
            }
        }
        if ($type == 'down') {
            foreach ($listLeaders as $key => $item) {
                if ($item['subtraction_price'] > 0) {
                    unset($listLeaders[$key]);
                }
            }
        }
        return $listLeaders;
    }

    private static function groupedByMarkets($list)
    {
        $result1 = [];
        foreach ($list as $key => $item) {
            $a = strtr($item['market'], ['USD'=>'USD', 'USDT'=> 'USD', 'USDC' => 'USD']);
            $result1[$a][] = $item;
        }
        //VarDumper::dump($result1,7,1);die;

        $result2 = [];
        foreach ($result1 as $key => $item) {
            $volume = [];
            $avg_price = [];
            $avg_subtraction_price = [];
            $avg_subtraction_price_percent = [];
            foreach ($item as $i) {
                array_push($volume, $i['volume']);
                array_push($avg_price, $i['now_avg_price']);
                array_push($avg_subtraction_price, $i['subtraction_price']);
                array_push($avg_subtraction_price_percent, $i['subtraction_price_percent']);
            }
            $result2[$key]['volume'] = array_sum($volume);
            $result2[$key]['avg_price'] = array_sum($avg_price)/count($avg_price);
            $result2[$key]['avg_subtraction_price'] = array_sum($avg_subtraction_price)/count($avg_subtraction_price);
            $result2[$key]['avg_subtraction_price_percent'] = array_sum($avg_subtraction_price_percent)/count($avg_subtraction_price_percent);
        }
        //VarDumper::dump($result2,7,1);die;
        return $result2;
    }


} // end class

//
//$average = array_sum($a)/count($a);
//echo $average;
//
//[
//    'BTC/USD' => [
//        0 => [
//            'id' => '13578'
//            'high' => '6660'
//            'low' => '6639.32440003'
//            'volume' => '22.56518743'
//            'market' => 'BTC/USD'
//            'exchange' => 'EXMO'
//            'timestamp' => '1538697600000'
//            'interval' => '1d'
//            'is_have_data' => true
//            'old_id' => '1'
//            'old_timestamp' => '1538611200000'
//            'old_volume' => '19.44609638'
//            'old_avg_price' => 6642.7666781
//            'now_avg_price' => 6649.662200015
//            'subtraction_price' => 6.895521915
//            'subtraction_price_percent' => 0.104
//        ]
//        1 => [
//            'id' => '13622'
//            'high' => '6593.8194161'
//            'low' => '6565.21'
//            'volume' => '1.12459689'
//            'market' => 'BTC/USDT'
//            'exchange' => 'EXMO'
//            'timestamp' => '1538697600000'
//            'interval' => '1d'
//            'is_have_data' => true
//            'old_id' => '23'
//            'old_timestamp' => '1538611200000'
//            'old_volume' => '7.1072622'
//            'old_avg_price' => 6562.93661562
//            'now_avg_price' => 6579.51470805
//            'subtraction_price' => 16.57809243
//            'subtraction_price_percent' => 0.253
//        ]
//        2 => [
//            'id' => '13634'
//            'high' => '6660.83004'
//            'low' => '6640.50447'
//            'volume' => '73.52894378'
//            'market' => 'BTC/USD'
//            'exchange' => 'LiveCoin'
//            'timestamp' => '1538697600000'
//            'interval' => '1d'
//            'is_have_data' => true
//            'old_id' => '39'
//            'old_timestamp' => '1538611200000'
//            'old_volume' => '35.39113967'
//            'old_avg_price' => 6622.569915
//            'now_avg_price' => 6650.667255
//            'subtraction_price' => 28.09734
//            'subtraction_price_percent' => 0.424
//        ]