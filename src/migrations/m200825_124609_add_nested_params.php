<?php

use yii\db\Migration;

/**
 * Class m200825_124609_add_nested_params
 */
class m200825_124609_add_nested_params extends Migration
{
    public function safeUp()
    {
        $this->addColumn('navigation', 'tree', $this->integer()->notNull());
        $this->addColumn('navigation', 'lft', $this->integer()->notNull());
        $this->addColumn('navigation', 'rgt', $this->integer()->notNull());
        $this->addColumn('navigation', 'depth', $this->integer()->notNull());
        $this->addColumn('navigation', 'position', $this->integer()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('navigation', 'position');
        $this->dropColumn('navigation', 'depth');
        $this->dropColumn('navigation', 'rgt');
        $this->dropColumn('navigation', 'lft');
        $this->dropColumn('navigation', 'tree');
    }

}
