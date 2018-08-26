<?php
/**
 * @copyright Copyright (C) 2015-2016 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use yii\web\AssetBundle;

class DsegFontAsset extends AssetBundle
{
    public $sourcePath = '@app/resources/dseg/dest';
    public $css = [
        'DSEG7Classic-RegularItalic.min.css',
    ];
}
