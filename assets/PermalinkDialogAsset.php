<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use yii\bootstrap\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class PermalinkDialogAsset extends AssetBundle
{
    public $sourcePath = '@app/resources/stat.ink-2/dest';
    public $css = [
        'permalink.min.css',
    ];
    public $js = [
        'permalink.min.js',
    ];
    public $depends = [
        AppAsset::class,
        BootstrapPluginAsset::class,
        JqueryAsset::class,
    ];
}
