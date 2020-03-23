<?php


namespace ityakutia\navigation;


use yii\base\BootstrapInterface;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->setModule('navigation', 'ityakutia\navigation\Module');
    }
}