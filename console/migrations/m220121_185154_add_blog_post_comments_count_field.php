<?php

use yii\db\Migration;

/**
 * Class m220121_185154_add_blog_post_comments_count_field
 */
class m220121_185154_add_blog_post_comments_count_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%blog_posts}}', 'comments_count', $this->integer()->notNull());
        
        $this->update('{{%blog_posts}}', ['comments_count' => 0]);
    }
    
    public function down()
    {
        $this->dropColumn('{{%blog_posts}}', 'comments_count');
    }
}
