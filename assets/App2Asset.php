<?php
/**
 * @copyright Copyright (C) 2015-2018 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use Yii;
use app\assets\BabelPolyfillAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\YiiAsset;

class App2Asset extends AssetBundle
{
    public $sourcePath = '@app/resources/stat.ink-2/dest';
    public $css = [];
    public $js = [];
    public $depends = [
        BabelPolyfillAsset::class,
        JqueryAsset::class,
        YiiAsset::class,
    ];

    public function addJs(string $filename): self
    {
        if (!in_array($filename, $this->js, true)) {
            $this->js[] = $filename;
        }
        return $this;
    }
}
