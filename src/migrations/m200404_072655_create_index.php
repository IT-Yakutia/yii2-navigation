<?php

use yii\db\Migration;

/**
 * Class m200404_072655_create_index
 */
class m200404_072655_create_index extends Migration
{

    public function safeUp()
    {
        $this->renameColumn('navigation', 'parent', 'parent_id');
        $this->addColumn('navigation', 'slug', $this->string()->notNull()->unique());
        // $this->createIndex('parent_sort', 'navigation', ['parent_id', 'sort'])
    }

    public function safeDown()
    {
        $this->dropColumn('navigation', 'slug');
        $this->renameColumn('navigation', 'parent_id', 'parent');
    }
}
