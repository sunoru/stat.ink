<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use yii\web\AssetBundle;

class UuidJsAsset extends AssetBundle
{
    public $sourcePath = '@bower/uuid.js/src';
    public $js = [
        'uuid.js',
    ];
}
