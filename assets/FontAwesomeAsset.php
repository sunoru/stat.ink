<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 */

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@npm/fortawesome--fontawesome-free';
    public $css = [
        'css/fontawesome.min.css',
    ];
    public $publishOptions = [
        'only' => [
            'css/*',
            'webfonts/*',
        ],
    ];

    public function load(string $type): self
    {
        if ($file = $this->type2file($type)) {
            if (!in_array($file, $this->css, true)) {
                $this->css[] = $file;
            }
        }

        return $this;
    }

    private function type2file(string $type): ?string
    {
        switch ($type) {
            case 'fa':
            case 'fas':
                return 'css/solid.min.css';

            case 'far':
                return 'css/regular.min.css';

            case 'fab':
                return 'css/brands.min.css';
        }

        return null;
    }
}
