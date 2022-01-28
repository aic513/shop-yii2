<?php

use yii\db\Migration;

/**
 * Class m220128_134214_add_user_phone_field
 */
class m220128_134214_add_user_phone_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%users}}', 'phone', $this->string()->Null());
        
        $this->createIndex('{{%idx-users-phone}}', '{{%users}}', 'phone', true);
    }
    
    public function down()
    {
        $this->dropColumn('{{%users}}', 'phone');
    }
}
