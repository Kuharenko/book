<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fa/css/fontawesome-all.min.css',
        'css/codemirror.css',
        'css/site.css',
        'css/main.css'

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/codemirror.js',
        'js/xml.js',
        'js/javascript.js',
        'js/css.js',
        'js/htmlmixed.js',
        'js/clike.js',
        'js/php.js',
        'js/typed.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
