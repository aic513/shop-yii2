<?php

use yii\db\Migration;

/**
 * Class m220202_205301_rename_active_column_discounts_table
 */
class m220202_205301_rename_active_column_discounts_table extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%shop_discounts}}', 'active', 'status');
    }
    
    public function down()
    {
        $this->renameColumn('{{%shop_discounts}}', 'status', 'active');
    }
}
