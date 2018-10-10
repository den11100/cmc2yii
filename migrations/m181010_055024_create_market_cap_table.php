<?php

use yii\db\Migration;

/**
 * Handles the creation of table `market_cap`.
 */
class m181010_055024_create_market_cap_table extends Migration
{
    public static $tableName = '{{%market_cap}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::$tableName, [
            'id' => $this->primaryKey(),
            'symbol' => $this->string(),
            'market_cap' => $this->double(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable(self::$tableName);
    }
}
