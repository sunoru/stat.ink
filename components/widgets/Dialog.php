<?php
namespace app\components\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Dialog extends Widget
{
    const FOOTER_OK = '{ok}';
    const FOOTER_CLOSE = '{close}';

    const SIZE_SMALL = 'modal-sm';
    const SIZE_MEDIUM = '';
    const SIZE_LARGE = 'modal-lg';

    public $title;
    public $hasClose = true;
    public $body;
    public $footer;
    public $fade = true;
    public $verticalCenter = false;
    public $size = self::SIZE_MEDIUM;
    public $titleFormat = 'text';
    public $headerOptions = [];
    public $wrapBody = true;

    public static function begin($config = [])
    {
        $r = parent::begin($config);
        ob_start();
        return $r;
    }

    public static function end()
    {
        $this->body = ob_get_clean();
        return parent::end();
    }

    public function __toString()
    {
        return $this->run();
    }

    public function run()
    {
        BootstrapAsset::register($this->view);
        BootstrapPluginAsset::register($this->view);

        return $this->renderBeginModal() .
            $this->renderHeader() .
            $this->renderBody() .
            $this->renderFooter() .
            $this->renderEndModal();
    }

    protected function renderBeginModal(): string
    {
        return Html::beginTag('div', [
                'id' => $this->id,
                'class' => [
                    'modal',
                    $this->fade ? 'fade' : '',
                ],
                'tabindex' => '-1',
                'role' => 'dialog',
            ]) .
            Html::beginTag('div', [
                'class' => [
                    'modal-dialog',
                    $this->verticalCenter ? 'modal-dialog-center' : '',
                    $this->size,
                ],
                'role' => 'document',
            ]) .
            Html::beginTag('div', [
                'class' => 'modal-content',
            ]);
    }

    protected function renderEndModal(): string
    {
        return Html::endTag('div') . Html::endTag('div') . Html::endTag('div');
    }

    protected function renderHeader(): string
    {
        $options = $this->headerOptions;
        $tag = ArrayHelper::getValue($options, 'tag', 'h5');
        $classes = (array)ArrayHelper::getValue($options, 'class', []);
        $classes[] = 'modal-title';
        $options['class'] = $classes;
        unset($options['tag']);

        return Html::tag(
            'div',
            implode('', [
                Html::tag(
                    $tag,
                    Yii::$app->formatter->format((string)$this->title, $this->titleFormat),
                    $options
                ),
                $this->hasClose
                    ? Html::tag(
                        'button',
                        Html::tag('span', FA::fas('times')->fw(), ['aria-hidden' => 'true']),
                        [
                            'type' => 'button',
                            'class' => 'close',
                            'data-dismiss' => 'modal',
                            'aria-label' => Yii::t('app', 'Close'),
                        ]
                    )
                    : '',
            ]),
            ['class' => 'modal-header']
        );
    }

    protected function renderBody(): string
    {
        return $this->wrapBody
            ? Html::tag('div', $this->body, ['class' => 'modal-body'])
            : $this->body;
    }

    protected function renderFooter(): string
    {
        if ($this->footer === null || $this->footer === false) {
            return '';
        }

        $footer = (string)$this->footer;
        if ($footer === static::FOOTER_OK) {
            $footer = Html::tag(
                'button',
                FA::fas('check') . ' ' . Html::encode(Yii::t('app', 'OK')),
                [
                    'type' => 'button',
                    'class' => 'btn btn-secondary',
                    'data-dismiss' => 'modal',
                ]
            );
        } elseif ($footer === static::FOOTER_CLOSE) {
            $footer = Html::tag(
                'button',
                FA::fas('times') . ' ' . Html::encode(Yii::t('app', 'Close')),
                [
                    'type' => 'button',
                    'class' => 'btn btn-secondary',
                    'data-dismiss' => 'modal',
                ]
            );
        }

        return Html::tag('div', $footer, ['class' => 'modal-footer']);
    }
}
