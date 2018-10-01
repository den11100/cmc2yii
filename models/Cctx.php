<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cctx".
 *
 * @property int $id
 * @property string $exchange
 * @property string $symbol
 * @property double $last
 * @property int $timestamp
 */
class Cctx extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cctx';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exchange'], 'string'],
            [['last'], 'number'],
            [['timestamp'], 'integer'],
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
            'exchange' => 'Exchange',
            'symbol' => 'Symbol',
            'last' => 'Last',
            'timestamp' => 'Timestamp',
        ];
    }
}
