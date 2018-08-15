<?php
namespace app\components\widgets;

use Yii;
use app\assets\DsegCounterAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SevenSegment extends Widget
{
    public $label;
    public $options = [];
    public $type;
    public $background = true;

    public function init()
    {
        parent::init();
        DsegCounterAsset::register($this->view);
    }

    public function run()
    {
        $options = (array)$this->options;
        $tag = ArrayHelper::getValue($options, 'tag', 'span');
        $classes = (array)ArrayHelper::getValue($options, 'class', []);
        $classes[] = 'dseg7';
        $classes[] = 'regular';
        $classes[] = 'italic';
        $classes[] = 'dseg-counter';
        unset($options['tag']);
        $options['class'] = $classes;
        $options['data-type'] = $this->type;

        return Html::tag(
            $tag,
            $this->renderBackground() . $this->renderForeground(),
            $options
        );
    }

    protected function renderForeground(): string
    {
        $text = trim((string)$this->label);
        return Html::encode($text);
    }

    protected function renderBackground(): string
    {
        $replaceMap = [
            ' ' => ':',
            '.' => '',
            '0' => '8.',
            '1' => '8.',
            '2' => '8.',
            '3' => '8.',
            '4' => '8.',
            '5' => '8.',
            '6' => '8.',
            '7' => '8.',
            '8' => '8.',
            '9' => '8.',
        ];

        $text = trim((string)$this->label);
        $text = preg_replace_callback('/./usi', function ($match): string {
            switch ($match[0]) {
                case ' ':
                    return ':';

                case '.':
                    return '';

                default:
                    return '8.';
            }
        }, $text);
        return Html::tag('span', Html::encode($text), [
            'aria-hidden' => 'true',
            'class' => [
                'dseg-counter-bg',
            ],
        ]);
    }
}
