<?php

namespace ityakutia\navigation\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class NavSortAsset extends AssetBundle
{
    public $sourcePath = '@ityakutia/navigation/assets/src/';
    
    public $css = [
        '//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css',
        'css/sortable.css',
    ];
    public $js = [
        '//code.jquery.com/ui/1.13.1/jquery-ui.js',
        'js/init.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
