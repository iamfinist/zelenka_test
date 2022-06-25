<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m220625_170225_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'real_id' => $this->integer()->unsigned()->notNull()->unique(),
            'user_name' => $this->string()->defaultValue(""),
            'user_phone' => $this->string()->defaultValue(""),
            'warehouse_id' => $this->string()->defaultValue(""),
            "created_at" => $this->integer(11),
            "updated_at" => $this->integer(11),
            "status" => $this->integer(),
            "items_count" => $this->integer()->unsigned()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
