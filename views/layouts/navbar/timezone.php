<?php
use app\components\widgets\FA;
use app\components\widgets\NavBarMenu;
use app\models\Country;
use app\models\Timezone;
use app\models\TimezoneGroup;
use yii\helpers\Html;

$currentTZ = Yii::$app->timeZone;
$formatTimezone = function (Timezone $tz) use ($currentTZ): array {
  // {{{
  $flags = implode('', array_map(
    function (Country $country): string {
      $flag = Html::tag('span', '', ['class' => [
        'flag-icon',
        'flag-icon-' . $country->key,
      ]]);
      return FA::hack($flag)->fw();
    },
    $tz->countries
  ));

  return [
    'icon' => FA::fas('check')->fw() . $flags,
    'label' => Yii::t('app-tz', $tz->name),
    'href' => 'javascript:;',
    'options' => [
      'class' => 'timezone-change',
      'data' => [
        'tz' => $tz->identifier,
      ],
    ],
  ];
  // }}}
};

echo NavBarMenu::widget([
  'icon' => FA::far('clock')->fw(),
  'label' => Yii::t('app', 'Time Zone'),
  'items' => array_merge(
    [
      $formatTimezone(Timezone::findOne(['identifier' => $currentTZ])), // special display: current TZ
      null,
    ],
    array_map(
      function (TimezoneGroup $group) use ($formatTimezone) {
        if (!$group->timezones) {
          return false;
        }

        return [
          'icon' => null,
          'label' => Yii::t('app', $group->name),
          'href' => 'javascript:;',
          'items' => array_map($formatTimezone, $group->timezones),
        ];
      },
      TimezoneGroup::find()->with(['timezones', 'timezones.countries'])->all()
    )
  ),
]);
__halt_compiler();
?>
<?= Html::a(
  implode('', [
    Html::tag('span', '', ['class' => 'far fa-fw fa-clock']),
    Html::encode(Yii::t('app', 'Time Zone')),
    ' ',
    Html::tag('span', '', ['class' => 'caret']),
  ]),
  'javascript:;',
  [
    'class' => 'dropdown-toggle',
    'data' => [
      'toggle' => 'dropdown',
    ],
    'role' => 'button',
    'aria-haspopup' => 'true',
    'aria-expanded' => 'false',
  ]
) . "\n" ?>
<?= Html::tag(
  'ul',
  implode('', [
    // 現在のタイムゾーンを特別表示 {{{
    (function (Timezone $tz) use ($currentTZ) : string {
      return Html::tag(
        'li',
        Html::a(
          implode('', [
            Html::tag('span', '', [
              'class' => [
                'fa',
                'fa-fw',
                ($currentTZ === $tz->identifier)
                  ? 'fa-check'
                  : '',
              ],
            ]),
            implode(' ', array_map(
              function (Country $country) : string {
                return Html::tag('span', '', ['class' => [
                  'flag-icon',
                  'flag-icon-' . $country->key,
                ]]);
              },
              $tz->countries
            )),
            ' ',
            Html::encode(Yii::t('app-tz', $tz->name)),
          ]),
          'javascript:;',
          [
            'class' => 'timezone-change',
            'data' => [
              'tz' => $tz->identifier,
            ],
          ]
        )
      );
    })(TimeZone::findOne(['identifier' => Yii::$app->timeZone])),
    // }}}
    Html::tag('li', '', ['class' => 'divider']),
    // 各タイムゾーングループ {{{
    implode('', array_map(
      function (TimezoneGroup $group) use ($currentTZ) : string {
        if (!$group->timezones) {
          return '';
        }
        return Html::tag(
          'li',
          implode('', [
            Html::a(
              Html::encode(Yii::t('app', $group->name)),
              'javascript:;',
              ['data' => [
                'toggle' => 'dropdown',
              ]]
            ),
            Html::tag(
              'ul',
              implode('', array_map(
                function (Timezone $tz) use ($currentTZ) : string {
                  return Html::tag(
                    'li',
                    Html::a(
                      implode('', [
                        Html::tag('span', '', [
                          'class' => [
                            'fa',
                            'fa-fw',
                            ($currentTZ === $tz->identifier)
                              ? 'fa-check'
                              : '',
                          ],
                        ]),
                        implode(' ', array_map(
                          function (Country $country) : string {
                            return Html::tag('span', '', ['class' => [
                              'flag-icon',
                              'flag-icon-' . $country->key,
                            ]]);
                          },
                          $tz->countries
                        )),
                        ' ',
                        Html::encode(Yii::t('app-tz', $tz->name)),
                      ]),
                      'javascript:;',
                      [
                        'class' => 'timezone-change',
                        'data' => [
                          'tz' => $tz->identifier,
                        ],
                      ]
                    )
                  );
                },
                $group->timezones
              )),
              ['class' => 'dropdown-menu']
            ),
          ]),
          ['class' => 'dropdown-submenu']
        );
      },
      TimezoneGroup::find()
        ->with(['timezones', 'timezones.countries'])
        ->all()
    )),
    // }}}
  ]),
  ['class' => 'dropdown-menu']
) ?>
