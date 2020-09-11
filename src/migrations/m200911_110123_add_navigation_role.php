<?php

use yii\db\Migration;

/**
 * Class m200911_110123_add_navigation_role
 */
class m200911_110123_add_navigation_role extends Migration
{
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $navigationRedactor = $auth->getPermission('navigation');
        if($navigationRedactor == null){
            $navigationRedactor = $auth->createPermission('navigation');
            $navigationRedactor->description = 'Редактирование навигации';

            $auth->add($navigationRedactor);

            $operator = $auth->getRole('operator');
            if($operator != null || $operator != false)
                $auth->addChild($operator,$navigationRedactor);
        }
    }

    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $navigationRedactor = $auth->getPermission('navigation');
        if($navigationRedactor !== null)
            $auth->remove($navigationRedactor);
        
    }
}
