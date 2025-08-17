<?php

use yii\db\Migration;

/**
 * Class m250817_145723_create_user_log_table
 */
class m250817_145723_create_user_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_log}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user_log-user_id',
            '{{%user_log}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_log-user_id', '{{%user_log}}');
        $this->dropTable('{{%user_log}}');
    }
}