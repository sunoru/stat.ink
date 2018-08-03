<?php
use app\components\widgets\FA;
use app\components\widgets\NavBarMenu;
use app\models\Language;
use app\models\SupportLevel;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

FlagIconCssAsset::register($this);

$languages = array_map(
  function (Language $lang): array {
    // {{{
    $levelIcon = (function (SupportLevel $level): string {
      switch ($level->id) {
        case SupportLevel::FULL:
        case SupportLevel::ALMOST:
          return FA::fas(null)->fw();

        case SupportLevel::PARTIAL:
          return FA::fas('exclamation-circle', ['options' => [
              'class' => 'auto-tooltip',
              'title' => 'Partially supported',
            ]])
            ->fw();

        case SupportLevel::FEW:
          return FA::fas('exclamation-triangle', ['options' => [
              'class' => 'auto-tooltip',
              'title' => 'Proper-noun only',
            ]])
            ->fw();
      }
    })($lang->supportLevel);
    return [
      'icon' => implode('', [
        FA::fas(Yii::$app->language === $lang->lang ? 'check' : null)->fw(),
        Html::tag('span', '', ['class' => [
          'flag-icon',
          'flag-icon-' . strtolower(substr($lang->lang, 3, 2)),
          'mr-1',
        ]]),
      ]),
      'labelFormat' => 'raw',
      'label' => implode('', [
        Html::encode(sprintf('%s / %s', $lang->name, $lang->name_en)),
        Html::tag('span', $levelIcon, ['class' => 'ml-2']),
      ]),
      'options' => [
        'hreflang' => $lang->lang,
        'data' => [
          'lang' => $lang->lang,
        ],
        'class' => [
          'language-change',
        ],
      ],
    ];
    // }}}
  },
  Language::find()->with('supportLevel')->orderBy(['name' => SORT_ASC])->all()
);

echo NavBarMenu::widget([
  'icon' => FA::fas('language')->fw(),
  'label' => 'Language',
  'items' => array_merge($languages, [
    null,
    [
      'icon' => FA::fas('question-circle')->fw(),
      'label' => Yii::t('app', 'About Translation'),
      'href' => ['/site/translate'],
    ],
  ]),
]);
