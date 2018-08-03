<?php
namespace app\components\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NavBarItem extends Widget
{
    public $icon;
    public $label;
    public $labelFormat = 'text';
    public $href;
    public $itemClass = self::class;
    public $items = [];
    public $options = [];

    public function run()
    {
        return $this->renderMyself() . $this->renderDropdown();
    }

    public function renderMyself(): string
    {
        return Html::a(
            $this->icon . Yii::$app->formatter->format($this->label, $this->labelFormat),
            $this->href,
            array_merge_recursive([
                'class' => ['dropdown-item'],
                'id' => $this->id,
            ], $this->options)
        );
    }

    public function renderDropdown(): string
    {
        if ($this->items) {
            return Html::tag('div', $this->renderItems(), [
                'class' => 'dropdown-menu',
                'aria-labelledby' => $this->id,
            ]);
        }

        return '';
    }

    public function renderItems(): string
    {
        return implode('', array_map(
            [$this, 'renderItem'],
            $this->items
        ));
    }

    public function renderItem($content): string
    {
        if ($content === null) {
            return Html::tag('div', '', ['class' => 'dropdown-divider']);
        } elseif ($content === false) {
            return '';
        } elseif (is_string($content)) {
            return $content;
        } elseif (is_array($content)) {
            if (!isset($content['class'])) {
                $content['class'] = $this->itemClass;
            }
            $content = Yii::createObject($content);
        }
        if ($content instanceof Widget) {
            return $content->run();
        } elseif (is_object($content)) {
            return $content->__toString();
        } else {
            throw new InvalidConfigException();
        }
    }
}
