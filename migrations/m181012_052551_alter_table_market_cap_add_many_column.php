<?php

use yii\db\Migration;

/**
 * Class m181012_052551_alter_table_market_cup_add_many_column
 */
class m181012_052551_alter_table_market_cap_add_many_column extends Migration
{
    private static $tableName = '{{%market_cap}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->truncateTable(self::$tableName)->execute();

        $this->dropColumn(self::$tableName, 'symbol');
        $this->dropColumn(self::$tableName, 'market_cap');

        $this->addColumn(self::$tableName, 'name', $this->string());
        $this->addColumn(self::$tableName, 'symbol', $this->string());
        $this->addColumn(self::$tableName, 'website_slug', $this->string());
        $this->addColumn(self::$tableName, 'rank', $this->integer());
        $this->addColumn(self::$tableName, 'circulating_supply', $this->bigInteger());
        $this->addColumn(self::$tableName, 'total_supply', $this->bigInteger());
        $this->addColumn(self::$tableName, 'max_supply', $this->bigInteger());
        $this->addColumn(self::$tableName, 'price', $this->double());
        $this->addColumn(self::$tableName, 'volume_24h', $this->double());
        $this->addColumn(self::$tableName, 'market_cap', $this->bigInteger());
        $this->addColumn(self::$tableName, 'percent_change_1h', $this->float());
        $this->addColumn(self::$tableName, 'percent_change_24h', $this->float());
        $this->addColumn(self::$tableName, 'percent_change_7d', $this->float());
        $this->addColumn(self::$tableName, 'last_updated', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->truncateTable(self::$tableName)->execute();

        $this->dropColumn(self::$tableName, 'name');
        $this->dropColumn(self::$tableName, 'symbol');
        $this->dropColumn(self::$tableName, 'website_slug');
        $this->dropColumn(self::$tableName, 'rank');
        $this->dropColumn(self::$tableName, 'circulating_supply');
        $this->dropColumn(self::$tableName, 'total_supply');
        $this->dropColumn(self::$tableName, 'max_supply');
        $this->dropColumn(self::$tableName, 'price');
        $this->dropColumn(self::$tableName, 'volume_24h');
        $this->dropColumn(self::$tableName, 'market_cap');
        $this->dropColumn(self::$tableName, 'percent_change_1h');
        $this->dropColumn(self::$tableName, 'percent_change_24h');
        $this->dropColumn(self::$tableName, 'percent_change_7d');
        $this->dropColumn(self::$tableName, 'last_updated');

        $this->addColumn(self::$tableName, 'symbol', $this->string());
        $this->addColumn(self::$tableName, 'market_cap', $this->double());
    }
}
