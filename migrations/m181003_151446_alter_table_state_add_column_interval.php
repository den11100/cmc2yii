<?php

use yii\db\Migration;

/**
 * Class m181003_151446_alter_table_state_add_column_interval
 */
class m181003_151446_alter_table_state_add_column_interval extends Migration
{
    private static $tableName = '{{%state}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::$tableName, 'interval', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::$tableName, 'interval');
    }
}
