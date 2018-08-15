<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class DsegCounterAsset extends AssetBundle
{
    public $sourcePath = '@app/resources/stat.ink-2/dest';
    public $css = [
        'dseg-counter.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        App2Asset::class,
        DsegFontAsset::class,
        JqueryAsset::class,
    ];
}
