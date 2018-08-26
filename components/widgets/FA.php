<?php
namespace app\components\widgets;

use Yii;
use app\assets\FontAwesomeAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class FA extends Widget
{
    public $tag = 'span';
    public $isFW = false;
    public $icon = null;
    public $type = 'fas';
    public $content = null;
    public $options = [];

    private $asset;

    public static function fas(?string $icon, array $options = []): self
    {
        return static::factory('fas', $icon, $options);
    }

    public static function far(?string $icon, array $options = []): self
    {
        return static::factory('far', $icon, $options);
    }

    public static function fab(?string $icon, array $options = []): self
    {
        return static::factory('fab', $icon, $options);
    }

    public static function fal(?string $icon, array $options = []): self
    {
        return static::factory('fal', $icon, $options);
    }

    public static function hack(string $content): self
    {
        return static::factory('fas', null, ['content' => $content]);
    }

    protected static function factory(string $type, ?string $icon, array $options): self
    {
        return Yii::createObject(ArrayHelper::merge([
            'class' => static::class,
            'type' => $type,
            'icon' => $icon,
        ], $options));
    }

    public function init()
    {
        parent::init();
        $this->asset = FontAwesomeAsset::register($this->view);
    }

    public function fw(): self
    {
        $this->isFW = true;
        return $this;
    }

    public function icon(?string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function __toString()
    {
        return $this->renderFA();
    }

    public function run()
    {
        echo $this->renderFA();
    }

    protected function renderFA(): string
    {
        if ($this->icon === 'twitter') {
            $this->view->registerCss('.fa-twitter{color:#1da1f2}');
        }

        $this->asset->load($this->type);

        return Html::tag($this->tag, $this->content ?? '', array_merge_recursive([
            'id' => $this->id,
            'class' => array_filter([
                $this->type,
                $this->isFW ? 'fa-fw' : null,
                $this->icon ? 'fa-' . $this->icon : null,
            ]),
        ], $this->options));
    }
}
