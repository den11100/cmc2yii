<?php

namespace app\models;

use Yii;
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
 */
class State extends \yii\db\ActiveRecord
{
    public static $states = [];
    public static $values = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
    }

    public static function prepareStates()
    {
        $times = [
            '1h' => [
                'from' => (time()-2*60*60)*1000,
                'to' => (time() - 60)*1000,
            ],
            '24h' => [
                'from' => (time()-24*60*60)*1000,
                'to' => (time() - 2*60*60)*1000,
            ],
            '2d' => [
                'from' => (time()-2*24*60*60)*1000,
                'to' => (time() - 24*60*60)*1000,
            ],
            '3d' => [
                'from' => (time()-3*24*60*60)*1000,
                'to' => (time() - 2*24*60*60)*1000,
            ],
            '4d' => [
                'from' => (time()-4*24*60*60)*1000,
                'to' => (time() - 3*24*60*60)*1000,
            ],
            '5d' => [
                'from' => (time()-5*24*60*60)*1000,
                'to' => (time() - 4*24*60*60)*1000,
            ],
            '6d' => [
                'from' => (time()-6*24*60*60)*1000,
                'to' => (time() - 5*24*60*60)*1000,
            ],
            '7d' => [
                'from' => (time()-7*24*60*60)*1000,
                'to' => (time() - 24*60*60)*1000,
            ],
            '14d' => [
                'from' => (time() - 14*24*60*60)*1000,
                'to' => (time()-7*24*60*60)*1000,
            ],
            '30d' => [
                'from' => (time()-30*24*60*60)*1000,
                'to' => (time() - 14*24*60*60)*1000,
            ],
            '45d' => [
                'from' => (time()-45*24*60*60)*1000,
                'to' => (time() - 14*24*60*60)*1000,
            ],
            '60d' => [
                'from' => (time()-60*24*60*60)*1000,
                'to' => (time() - 45*24*60*60)*1000,
            ],
            '90d' => [
                'from' => (time()-90*24*60*60)*1000,
                'to' => (time() - 60*24*60*60)*1000,
            ],
            '200d' => [
                'from' => (time()-200*24*60*60)*1000,
                'to' => (time() - 90*24*60*60)*1000,
            ],
        ];

        foreach ($times as $time => $values){
            self::$states[$time] = State::find()
                ->where(['LIKE', 'market', '/USD',])
                ->andWhere(['between', 'timestamp', $values['from'], $values['to'], ])
                ->groupBy('exchange, market')
                ->all();
        }

        $statesByTimeAndSymbols = [];
        foreach (self::$states as $time => $states){
            /** @var State $state */
            foreach ($states as $state){
                if (!empty($state)){
                    $statesByTimeAndSymbols[$time][$state->getSymbol()][] = $state->getMiddleValue();
                }
            }
        }

        foreach ($statesByTimeAndSymbols as $time => $statesBySymbols){
            foreach ($statesBySymbols as $symbol => $states){
                self::$values[$time][$symbol] = array_sum($states) / count($states);
            }
        }
    }

    public static function getAvgValue($tm, $symbol)
    {
        return isset(self::$values[$tm][$symbol]) ? self::$values[$tm][$symbol] : null;
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

        $percent = round((1 - $valueThat / $valueCurrent) * 100, 2);

        if ($percent > 0){
            $percent = '+' . $percent;
        } else {
            $percent = '-' . (-1)*$percent;
        }

        $diff = $valueCurrent-$valueThat;

        return  '<span class="bd">'.$percent . '%</span>' . "&nbsp;<span class=\"sm\">(".round($diff, 2)."$)</span>";
    }

    public static function getPercentGradation($valueCurrent, $valueThat)
    {
        if (!$valueCurrent || !$valueThat){
            return null;
        }

        $percent = round((1 - $valueThat / $valueCurrent) * 100, 2);

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
            [['high', 'low', 'volume'], 'number'],
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
        ];
    }


}
