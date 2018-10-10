<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "market_cap".
 *
 * @property int $id
 * @property string $symbol
 * @property double $market_cap
 */
class MarketCap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market_cap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['market_cap'], 'number'],
            [['symbol'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'market_cap' => 'Market Cap',
        ];
    }
}
