<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "market_cap".
 *
 * @property int $id
 * @property string $name
 * @property string $symbol
 * @property string $website_slug
 * @property int $rank
 * @property int $circulating_supply
 * @property int $total_supply
 * @property int $max_supply
 * @property double $price
 * @property double $volume_24h
 * @property int $market_cap
 * @property double $percent_change_1h
 * @property double $percent_change_24h
 * @property double $percent_change_7d
 * @property int $last_updated
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
            [['rank', 'circulating_supply', 'total_supply', 'max_supply', 'market_cap', 'last_updated'], 'integer'],
            [['price', 'volume_24h', 'percent_change_1h', 'percent_change_24h', 'percent_change_7d'], 'number'],
            [['name', 'symbol', 'website_slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'symbol' => 'Symbol',
            'website_slug' => 'Website Slug',
            'rank' => 'Rank',
            'circulating_supply' => 'Circulating Supply',
            'total_supply' => 'Total Supply',
            'max_supply' => 'Max Supply',
            'price' => 'Price',
            'volume_24h' => 'Volume 24h',
            'market_cap' => 'Market Cap',
            'percent_change_1h' => 'Percent Change 1h',
            'percent_change_24h' => 'Percent Change 24h',
            'percent_change_7d' => 'Percent Change 7d',
            'last_updated' => 'Last Updated',
        ];
    }

    public static function saveMarketCup($marketCapArray)
    {
        $newArray = [];
        foreach ($marketCapArray as $item){
            foreach ($item['data'] as $i) {
                $newArray[] = $i;
            }
        }
        //VarDumper::dump($newArray,7,1);die;

        $result = [];
        foreach ($newArray as $key => $item) {
            $result[] = [
                $item['name'],
                $item['symbol'],
                $item['website_slug'],
                $item['rank'],
                $item['circulating_supply'],
                $item['total_supply'],
                $item['max_supply'],
                $item['quotes']['USD']['price'],
                $item['quotes']['USD']['volume_24h'],
                $item['quotes']['USD']['market_cap'],
                $item['quotes']['USD']['percent_change_1h'],
                $item['quotes']['USD']['percent_change_24h'],
                $item['quotes']['USD']['percent_change_7d'],
                $item['last_updated'],
            ];
        }
        Yii::$app->db->createCommand()->truncateTable('{{%market_cap}}')->execute();
        Yii::$app->db->createCommand()->batchInsert('{{%market_cap}}', [
            'name',
            'symbol',
            'website_slug',
            'rank',
            'circulating_supply',
            'total_supply',
            'max_supply',
            'price',
            'volume_24h',
            'market_cap',
            'percent_change_1h',
            'percent_change_24h',
            'percent_change_7d',
            'last_updated',
        ], $result)->execute();
    }
}
