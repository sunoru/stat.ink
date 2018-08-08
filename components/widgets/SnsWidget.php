<?php
/**
 * @copyright Copyright (C) 2016 AIZAWA Hina
 * @license https://github.com/fetus-hina/stat.ink/blob/master/LICENSE MIT
 * @author AIZAWA Hina <hina@bouhime.com>
 * @author Yoshiyuki Kawashima <ykawashi7@gmail.com>
 */

namespace app\components\widgets;

use Yii;
use app\assets\PermalinkDialogAsset;
use jp3cki\yii2\twitter\widget\TweetButton;
use yii\base\Widget;
use yii\helpers\Html;

class SnsWidget extends Widget
{
    public static $autoIdPrefix = 'sns-';
    public $template;

    public $tweetButton;
    public $feedUrl;

    private $initialized = false;

    public function init()
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        parent::init();

        // <div id="{id}" class="sns">{tweet} {permalink}</div>
        $this->template = Html::tag('div', '{tweet} {permalink} {feed}', [
            'id' => '{id}',
            'class' => [
                'sns',
            ],
        ]);
        $this->tweetButton = Yii::createObject([
            'class' => TweetButton::class
        ]);
    }

    public function __set($key, $value)
    {
        $this->init();
        if (preg_match('/^tweet(.+)$/', $key, $match)) {
            $attr = lcfirst($match[1]);
            $this->tweetButton->$attr = $value;
        } else {
            parent::__set($key, $value);
        }
    }

    public function run()
    {
        $replace = [
            'id' => $this->id,
            'tweet' => function () {
                return $this->tweetButton->run();
            },
            'permalink' => function () {
                return $this->procPermaLink();
            },
            'feed' => function () {
                return $this->procFeed();
            },
        ];
        return preg_replace_callback(
            '/\{(\w+)\}/',
            function ($match) use ($replace) {
                if (isset($replace[$match[1]])) {
                    $value = $replace[$match[1]];
                    return is_callable($value) ? $value() : $value;
                }
                return $match[0];
            },
            $this->template
        );
    }

    protected function procPermaLink()
    {
        PermalinkDialogAsset::register($this->view);
        $id = $this->id . '-permalink';
        $dialog = Yii::createObject([
            'class' => Dialog::class,
            'title' => Yii::t('app', 'Permalink'),
            'footer' => Dialog::FOOTER_CLOSE,
            'body' => sprintf(
                '<p>%s</p>%s',
                Html::encode(Yii::t('app', 'Please copy this URL:')),
                Html::textInput('', 'url', [
                    'class' => 'form-control',
                    'readonly' => true,
                ])
            ),
        ]);

        return Html::tag(
            'span',
            implode(' ', [
                Html::tag('span', '', ['class' => 'fa fa-fw fa-anchor']),
                Html::encode(Yii::t('app', 'Permalink')),
            ]),
            [
                'id' => $id,
                'class' => [
                    'badge',
                    'badge-success',
                    'badge-permalink',
                    'auto-tooltip',
                ],
                'data' => [
                    'target' => '#' . $dialog->id,
                ],
            ]
        ) . $dialog;
    }

    protected function procFeed()
    {
        $id = $this->id . '-feed';
        if (!$this->feedUrl) {
            return null;
        }
        $this->view->registerCss(sprintf(
            '.label-feed{%s}.label-feed[href]:hover{%s}',
            Html::cssStyleFromArray([
                'cursor'            => 'pointer',
                'display'           => 'inline-block',
                'font-size'         => '11px',
                'font-weight'       => '500',
                'height'            => '20px',
                'padding'           => '5px 6px 1px',
                'vertical-align'    => 'top',
                'background-color'  => '#ff7010',
            ]),
            Html::cssStyleFromArray([
                'background-color'  => '#dc5800',
            ])
        ));
        return Html::tag(
            'a',
            Html::tag('span', '', ['class' => 'fa fa-fw fa-rss']),
            [
                'id' => $id,
                'class' => [
                    'label',
                    'label-warning',
                    'label-feed',
                    'auto-tooltip',
                ],
                'href' => $this->feedUrl,
            ]
        );
    }
}
