<?php

use yii\db\Migration;

/**
 * Class m200330_181535_add_navigation_link
 */
class m200330_181535_add_navigation_link extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('navigation', 'link', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('navigation', 'link');
    }
}
