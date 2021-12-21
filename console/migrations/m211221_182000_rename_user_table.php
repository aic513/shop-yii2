<?php

use yii\db\Migration;

/**
 * Class m211221_182000_rename_user_table
 */
class m211221_182000_rename_user_table extends Migration
{
    public function up()
    {
        $this->renameTable('{{%user}}', '{{%users}}');
    }

    public function down()
    {
        $this->renameTable('{{%users}}', '{{%user}}');
    }
}
