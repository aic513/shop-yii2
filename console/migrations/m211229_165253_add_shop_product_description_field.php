<?php

use yii\db\Migration;

/**
 * Class m211229_165253_add_shop_product_description_field
 */
class m211229_165253_add_shop_product_description_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_products}}', 'description', $this->text()->after('name'));
    }
    
    public function down()
    {
        $this->dropColumn('{{%shop_products}}', 'description');
    }
}
