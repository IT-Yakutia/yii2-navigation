<?php

use yii\db\Migration;

/**
 * Class m200423_183936_add_color_switcher
 */
class m200423_183936_add_color_switcher extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('navigation', 'color_switcher', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('navigation', 'color_switcher');
    }

}
