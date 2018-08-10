<?php
namespace app\components\widgets;

use Yii;
use app\models\Language;
use app\models\SupportLevel;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

class LanguageDialog extends Dialog
{
    public function init()
    {
        parent::init();
        $this->title = implode(' ', [
            FA::fas('language')->fw(),
            Html::encode('Choose your language'),
        ]);
        $this->titleFormat = 'raw';
        $this->hasClose = true;
        $this->footer = Dialog::FOOTER_CLOSE;
        $this->body = $this->createBody();
        $this->wrapBody = false;
    }

    private function createBody(): string
    {
        return Html::tag(
            'div',
            implode('', array_merge(
                $this->createLanguageList(),
                $this->createHintList()
            )),
            ['class' => 'list-group-flush']
        );
    }

    private function createLanguageList(): array
    {
        return array_map(
            function (Language $lang): string {
                if ($lang->lang === Yii::$app->language) {
                    return Html::tag('div', $this->renderLanguageItem($lang), [
                        'class' => 'list-group-item bg-primary text-light',
                    ]);
                } else {
                    return Html::a($this->renderLanguageItem($lang), 'javascript:;', [
                        'class' => [
                            'list-group-item',
                            'language-change',
                            'text-dark',
                        ],
                        'data' => [
                            'lang' => $lang->lang,
                        ],
                        'hreflang' => $lang->lang,
                    ]);
                }
            },
            Language::find()->with('supportLevel')->orderBy(['name' => SORT_ASC])->all()
        );
    }

    private function renderLanguageItem(Language $lang): string
    {
        FlagIconCssAsset::register($this->view);

        $flag =  Html::tag('span', '', ['class' => [
            'flag-icon',
            'flag-icon-' . strtolower(substr($lang->lang, 3, 2)),
            'mr-1',
        ]]);

        $label = ($lang->name === $lang->name_en)
            ? $lang->name
            : sprintf('%s / %s', $lang->name, $lang->name_en);

        $levelIcon = $this->renderSupportLevelIcon($lang->supportLevel);

        $left = Html::tag('span', implode('', [
            $flag,
            Html::encode($label),
        ]));

        $right = Html::tag('span', implode('', [
            $levelIcon,
        ]));

        return Html::tag(
            'div',
            $left . $right,
            ['class' => [
                'd-flex',
                'justify-content-between',
            ]]
        );
    }

    private function renderSupportLevelIcon(SupportLevel $level): string
    {
        switch ($level->id) {
            case SupportLevel::FULL:
            case SupportLevel::ALMOST:
                return FA::fas(null)->fw();

            case SupportLevel::PARTIAL:
                return FA::fas('exclamation-circle', ['options' => [
                    'class' => 'auto-tooltip',
                    'title' => 'Partially supported',
                ]])->fw();

            case SupportLevel::FEW:
                return FA::fas('exclamation-triangle', ['options' => [
                    'class' => 'auto-tooltip',
                    'title' => 'Proper-noun only',
                ]])->fw();
        }
    }

    private function createHintList(): array
    {
        return [
            Html::tag(
                'div',
                Html::tag(
                    'div',
                    implode('<br>', [
                      FA::fas('exclamation-circle')->fw() . ' : Partically supported',
                      FA::fas('exclamation-triangle')->fw() . ' : Proper-noun only',
                    ]),
                    [
                        'class' => 'ml-auto',
                    ]
                ),
                [
                    'class' => 'list-group-item bg-secondary text-light small pt-1 pb-1 d-flex',
                ]
            ),
            Html::a(
                FA::fas('question-circle')->fw() . ' About Translation',
                ['site/translate'],
                ['class' => 'list-group-item text-dark']
            ),
            Html::a(
                FA::fas('sync')->fw() . ' How to update',
                'https://github.com/fetus-hina/stat.ink/wiki/Translation',
                ['class' => 'list-group-item text-dark']
            ),
        ];
    }
}
