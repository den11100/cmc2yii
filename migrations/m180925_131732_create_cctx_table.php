<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cctx`.
 */
class m180925_131732_create_cctx_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cctx', [
            'id' => $this->primaryKey(),
            'exchange' => $this->text(),
            'symbol' => $this->string(),
            'last' => $this->double(),
            'timestamp' => $this->bigInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cctx');
    }
}
