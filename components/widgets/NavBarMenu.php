<?php
namespace app\components\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class NavBarMenu extends Widget
{
    public $icon;
    public $label;
    public $labelFormat = 'text';
    public $itemClass = NavBarItem::class;
    public $items = [];

    public function run()
    {
        return $this->renderTopLevel() . $this->renderDropdown();
    }

    public function renderTopLevel(): string
    {
        return Html::a(
            $this->icon . Yii::$app->formatter->format($this->label, $this->labelFormat),
            'javascript:;',
            [
                'class' => ['nav-link', 'dropdown-toggle'],
                'id' => $this->id,
                'role' => 'button',
                'data' => [
                    'toggle' => 'dropdown',
                ],
                'aria-haspopup' => 'true',
                'aria-expanded' => 'false',
            ]
        );
    }

    public function renderDropdown(): string
    {
        return Html::tag('div', $this->renderItems(), [
            'class' => 'dropdown-menu',
            'aria-labelledby' => $this->id,
        ]);
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
