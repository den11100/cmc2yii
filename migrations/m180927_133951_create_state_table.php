<?php

use yii\db\Migration;

/**
 * Handles the creation of table `state`.
 */
class m180927_133951_create_state_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('state', [
            'id' => $this->primaryKey(),
            'high' => $this->double(),
            'low' => $this->double(),
            'volume' => $this->double(),
            'market' => $this->string(),
            'exchange' => $this->string(),
            'timestamp' => $this->bigInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('state');
    }
}
