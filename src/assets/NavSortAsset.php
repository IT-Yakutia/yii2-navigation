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
        'css/sortable.css',
    ];
    public $js = [
        'js/init.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
