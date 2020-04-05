<?php

use yii\db\Migration;

/**
 * Class m200405_171157_delete_slug
 */
class m200405_171157_delete_slug extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('navigation', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('navigation', 'slug', $this->string()->notNull());
    }
}
