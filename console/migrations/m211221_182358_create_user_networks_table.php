<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_networks}}`.
 */
class m211221_182358_create_user_networks_table extends Migration
{
    public function up()
    {

        $this->createTable('{{%user_networks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'identity' => $this->string()->notNull(),
            'network' => $this->string(16)->notNull(),
        ]);

        $this->createIndex('{{%idx-user_networks-identity-name}}', '{{%user_networks}}', ['identity', 'network'], true);

        $this->createIndex('{{%idx-user_networks-user_id}}', '{{%user_networks}}', 'user_id');

        $this->addForeignKey('{{%fk-user_networks-user_id}}', '{{%user_networks}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%user_networks}}');
    }
}
