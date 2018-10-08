<?php

use yii\db\Migration;

/**
 * Class m181008_061329_alter_teble_state_add_column_open_and_close
 */
class m181008_061329_alter_teble_state_add_column_open_and_close extends Migration
{
    private static $tableName = '{{%state}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::$tableName, 'open', $this->double());
        $this->addColumn(self::$tableName, 'close', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::$tableName, 'close');
        $this->dropColumn(self::$tableName, 'open');
    }
}
