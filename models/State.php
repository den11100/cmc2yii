<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "state".
 *
 * @property int $id
 * @property double $high
 * @property double $low
 * @property double $volume
 * @property string $market
 * @property string $exchange
 * @property int $timestamp
 * @property int $interval
 * @property double $open
 * @property double $close
 */
class State extends \yii\db\ActiveRecord
{
    public static $states = [];
    public static $values = [];
    public static $volumes = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
    }

    public static function prepareStatesDays()
    {
        $times = [];
        $times['0d']['to'] = (time() - 1*1*1*60)*1000;
        $times['0d']['from'] = (time()-1*24*60*60)*1000;

        $times['1d']['to'] = (time() - 2*60*60)*1000;
        $times['1d']['from'] = (time()-1*24*60*60)*1000;

        for ($i = 2; $i <= 200; $i++){
            $times[$i.'d']['to'] = (time() - ($i)*24*60*60)*1000;
            $times[$i.'d']['from'] = (time()-($i+1)*24*60*60)*1000;
        }

        $times['45d']['to'] = (time() - 14*24*60*60)*1000;
        $times['45d']['from'] = (time()-45*24*60*60)*1000;

        $times['90d']['to'] = (time() - 60*24*60*60)*1000;
        $times['90d']['from'] = (time()-90*24*60*60)*1000;

        $times['200d']['to'] = (time() - 90*24*60*60)*1000;
        $times['200d']['from'] = (time()-200*24*60*60)*1000;

        foreach ($times as $time => $values){
            self::$states[$time] = State::find()
                ->where(['LIKE', 'market', '/USD',])
                ->andWhere(['interval' => "1d"])
                ->andWhere(['between', 'timestamp', $values['from'], $values['to'], ])
                ->groupBy('exchange, market')
                ->all();
        }
        //VarDumper::dump(self::$states[$time],7,1);die;
        $statesByTimeAndSymbols = [];
        foreach (self::$states as $time => $states){
            /** @var State $state */
            foreach ($states as $state){
                if (!empty($state)){
                    $statesByTimeAndSymbols[$time][$state->getSymbol()]['value'][] = $state->getMiddleValue();
                    $statesByTimeAndSymbols[$time][$state->getSymbol()]['volume'][] = $state->volume;
                }
            }
        }

        foreach ($statesByTimeAndSymbols as $time => $statesBySymbols){
            foreach ($statesBySymbols as $symbol => $states){
                self::$values[$time][$symbol] = array_sum($states['value']) / count($states['value']);
                self::$volumes[$time][$symbol] = array_sum($states['volume']) / count($states['volume']);
            }
        }

        self::prepareStatesMinutes();
    }

    public static function prepareStatesMinutes()
    {
        $states = State::find()
            ->where(['interval' => '1m'])
            ->andWhere(['between', 'timestamp', (time()-4*60*60)*1000, (time())*1000, ])
            ->groupBy('exchange, market')
            ->all();

        $statesByTime = [];
        /** @var State $state */
        foreach ($states as $state){
            $statesByTime['4h'][$state->getSymbol()]['value'][] = $state->getMiddleValue();
        }

        foreach ($statesByTime as $time => $statesBySymbols){
            foreach ($statesBySymbols as $symbol => $states){
                self::$values[$time][$symbol] = array_sum($states['value']) / count($states['value']);
            }
        }
    }

    public static function getAvgValue($tm, $symbol)
    {
        return isset(self::$values[$tm][$symbol]) ? self::$values[$tm][$symbol] : null;
    }

    public static function getVolume($tm, $symbol)
    {
        return isset(self::$volumes[$tm][$symbol]) ? self::$volumes[$tm][$symbol] : null;
    }

    public static function hydrate($value)
    {
        return $value ? '$ '.number_format($value, 2) : null;
    }

    public static function hydratePercent($valueCurrent, $valueThat)
    {
        if (!$valueCurrent || !$valueThat){
            return null;
        }

        $percent = round((1 - $valueCurrent / $valueThat) * 100, 2) * (-1);

        if ($percent > 0){
            $percent = '+' . $percent;
        } else {
            $percent = '-' . (-1)*$percent;
        }

        $diff = $valueCurrent-$valueThat;

        return  '<span class="bd">'.$percent . '%</span>' . "<br><span class=\"sm\">(".round($diff, 2)."$)</span>";
    }

    public static function getPercentGradation($valueCurrent, $valueThat)
    {
        if (!$valueCurrent || !$valueThat){
            return null;
        }

        $percent = round((1 - $valueCurrent / $valueThat) * 100, 2) * (-1);

        if (!$percent){
            return null;
        }

        $start = 0;
        if ($percent < 0){
            $start = 5;
            $percent *= -1;
        }

        if ($percent > 80){
            return $start + 4;
        }
        if ($percent > 60){
            return $start + 3;
        }
        if ($percent > 40){
            return $start + 3;
        }
        if ($percent > 20){
            return $start + 2;
        }
        if ($percent > 10){
            return $start + 1;
        }
        if ($percent > 0){
            return $start;
        }
    }

    public static function getThirtyDaysPlot($symbol)
    {

    }

    public function getSymbol()
    {
        return str_replace(['/USDT', '/USD', ], '', $this->market);
    }

    public function getMiddleValue()
    {
        return ($this->high + $this->low)/2;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['high', 'low', 'volume', 'open', 'close'], 'number'],
            [['timestamp'], 'integer'],
            [['market', 'exchange', 'interval'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'high' => 'High',
            'low' => 'Low',
            'volume' => 'Volume',
            'market' => 'Market',
            'exchange' => 'Exchange',
            'timestamp' => 'Timestamp',
            'interval' => 'Interval',
            'open' => 'Open',
            'close' => 'Close',
        ];
    }

    public static function getDataPrice($symbol, $days)
    {
        $result = [];
        for($i = 0; $i <= $days; $i++)
        {
            $result[] = [(time()-$i*24*60*60)*1000, (float)State::getAvgValue($i.'d', $symbol)];
        }
        return $result;

    }

    public static function getDataVolume($symbol, $days)
    {
        $result = [];
        for($i = 0; $i <= $days; $i++)
        {
            $result[] = [(time()-$i*24*60*60)*1000, (float)State::getVolume($i.'d', $symbol)];
        }
        return $result;
    }

    public static function getPriceAndVolumeList($interval, $symbol, $chart)
    {
        /* находим id записей максимально близкие к now */
        $array = State::find()
            ->where(new Expression('timestamp BETWEEN UNIX_TIMESTAMP(NOW() - INTERVAL '.$chart.')*1000 AND UNIX_TIMESTAMP(NOW())*1000'))
            ->andWhere(['interval' => $interval])
            ->andWhere(['market' => $symbol.'/USD'])
            ->orderBy('timestamp asc')
            ->asArray()
            ->all();

        $idRowTimestampLessToNow = ArrayHelper::getColumn($array,'id');
        $list = State::find()
            ->select('timestamp, avg(high) as avg_high, avg(low) as avg_low, avg(volume) as avg_volume')
            ->where(['in', 'id', $idRowTimestampLessToNow])
            ->asArray()
            ->groupBy('timestamp')
            ->all();

        $priceList = [];
        $volumeList = [];
        foreach ($list as $key => $item) {
            $avg_prise = ($item['avg_high'] + $item['avg_low'])/2;
            array_push($priceList, [1*$item['timestamp'], $avg_prise, ]);
            array_push($volumeList, [1*$item['timestamp'], $item['avg_volume']*1, ]);
        }

        return ["priceList" => $priceList, "volumeList" => $volumeList];
    }

}