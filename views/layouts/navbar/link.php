<?php
use app\assets\AppLinkAsset;
use app\components\widgets\FA;
use app\components\widgets\NavBarMenu;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

$icon = AppLinkAsset::register($this);

$flag = function (string $cc): string {
  FlagIconCssAsset::register($this);
  return FA::hack(Html::tag('span', '', ['class' => ['flag-icon', 'flag-icon-' . $cc]]))->fw();
};

echo NavBarMenu::widget([
  'icon' => FA::fas('link')->fw(),
  'label' => Yii::t('app', 'Link'),
  'items' => [
    [
      // S2 official {{{
      'label' => Yii::t('app', '{title} Official Website', [
        'title' => Yii::t('app', 'Splatoon 2'),
      ]),
      'items' => [
        [
          'icon' => $flag('jp'),
          'href' => 'https://www.nintendo.co.jp/switch/aab6a',
          'label' => Yii::t('app', 'Japan'),
        ],
        [
          'icon' => $flag('us'),
          'href' => 'http://splatoon.nintendo.com/',
          'label' => Yii::t('app', 'North America'),
        ],
        [
          'icon' => $flag('eu'),
          'href' => 'https://www.nintendo.co.uk/Games/Nintendo-Switch/Splatoon-2-1173295.html',
          'label' => Yii::t('app', 'Europe'),
        ],
      ],
      // }}}
    ],
    [
      // S1 official {{{
      'label' => Yii::t('app', '{title} Official Website', [
        'title' => Yii::t('app', 'Splatoon'),
      ]),
      'items' => [
        [
          'icon' => $flag('jp'),
          'href' => 'http://www.nintendo.co.jp/wiiu/agmj/',
          'label' => Yii::t('app', 'Japan'),
        ],
        [
          'icon' => $flag('us'),
          'href' => 'http://splatoon.nintendo.com/splatoon/',
          'label' => Yii::t('app', 'North America'),
        ],
        [
          'icon' => $flag('eu'),
          'href' => 'https://www.nintendo.co.uk/Games/Wii-U/Splatoon-892510.html',
          'label' => Yii::t('app', 'Europe'),
        ],
      ],
      // }}}
    ],
    [
      // Twitter {{{
      'icon' => FA::fab('twitter')->fw(),
      'label' => Yii::t('app', 'Official Twitter'),
      'items' => [
        [
          'icon' => $flag('jp'),
          'href' => 'https://twitter.com/SplatoonJP',
          'label' => Yii::t('app', 'Japan'),
        ],
        [
          'icon' => $flag('us'),
          'href' => 'https://twitter.com/NintendoAmerica',
          'label' => Yii::t('app', 'North America') . ' (Nintendo)',
        ],
        [
          'icon' => $flag('us'),
          'href' => 'https://twitter.com/NintendoVS',
          'label' => Yii::t('app', 'North America') . ' (Nintendo VS)',
        ],
        [
          'icon' => $flag('eu'),
          'href' => 'https://twitter.com/NintendoEurope',
          'label' => Yii::t('app', 'Europe') . ' (Nintendo)',
        ],
      ],
      // }}}
    ],
    [
      // Official app {{{
      'label' => Yii::t('app', 'Nintendo Switch Online app'),
      'items' => [
        [
          'icon' => FA::fab('android')->fw(),
          'label' => Yii::t('app', 'Android'),
          'href' => 'https://play.google.com/store/apps/details?id=com.nintendo.znca',
        ],
        [
          'icon' => FA::fab('apple')->fw(),
          'label' => Yii::t('app', 'iOS (iPhone/iPad)'),
          'href' => 'https://itunes.apple.com/app/nintendo-switch-online/id1234806557',
        ],
      ],
      // }}}
    ],
    null,
    [
      // SquidTracks {{{
      'icon' => $icon->squidTracks,
      'href' => 'https://github.com/hymm/squid-tracks/',
      'label' => implode('', [
        Html::encode(Yii::t('app', 'SquidTracks')),
        FA::fab('windows')->fw(),
        FA::fab('apple')->fw(),
        FA::fab('linux')->fw(),
      ]),
      'labelFormat' => 'raw',
      // }}}
    ],
    [
      // splatnet2statink {{{
      'icon' => FA::fas(null)->fw(),
      'href' => 'https://github.com/frozenpandaman/splatnet2statink/',
      'label' => implode('', [
        Html::encode(Yii::t('app', 'splatnet2statink')),
        FA::fab('windows')->fw(),
        FA::fab('apple')->fw(),
        FA::fab('linux')->fw(),
      ]),
      'labelFormat' => 'raw',
      // }}}
    ],
    [
      // IkaRec 2 {{{
      'icon' => $icon->ikarecJa,
      'href' => 'https://play.google.com/store/apps/details?id=com.syanari.merluza.ikarec2',
      'label' => implode('', [
        Html::encode(Yii::t('app', 'IkaRec 2')),
        FA::fab('android')->fw(),
      ]),
      'labelFormat' => 'raw',
      // }}}
    ],
    null,
    [
      // Apps for Spl 1 {{{
      'label' => Yii::t('app', 'Apps for {version}', ['version' => Yii::t('app', 'Splatoon 1')]),
      'items' => [
        [
          // IkaLog {{{
          'icon' => $icon->ikalog,
          'label' => implode('', [
            Html::encode(Yii::t('app', 'IkaLog')),
            FA::fab('windows')->fw(),
            FA::fab('apple')->fw(),
            FA::fab('linux')->fw(),
          ]),
          'labelFormat' => 'raw',
          'items' => [
            [
              'icon' => $flag('jp'),
              'label' => '日本語',
              'href' => 'https://github.com/hasegaw/IkaLog/wiki/ja_WinIkaLog',
            ],
            [
              'icon' => $flag('us'),
              'label' => 'English',
              'href' => 'https://github.com/hasegaw/IkaLog/wiki/en_Home',
            ],
            null,
            [
              'icon' => FA::fas('download')->fw(),
              'href' => 'https://hasegaw.github.io/IkaLog/',
              'label' => implode('', [
                Yii::t('app', 'IkaLog Download Page'),
                '(' . Yii::t('app', 'Windows') . ')',
              ]),
            ],
          ],
          // }}}
        ],
        [
          // IkaRec {{{
          'icon' => $icon->ikarecJa,
          'label' => Html::encode(Yii::t('app', 'IkaRec')) . ' ' . FA::fab('android'),
          'labelFormat' => 'raw',
          'items' => [
            [
              'icon' => $icon->ikarecJa,
              'label' => '日本語',
              'href' => 'https://play.google.com/store/apps/details?id=com.syanari.merluza.ikarec',
            ],
            [
              'icon' => $icon->ikarecEn,
              'label' => 'English',
              'href' => 'https://play.google.com/store/apps/details?id=ink.pocketgopher.ikarec',
            ],
          ],
          // }}}
        ],
      ],
      // }}}
    ],
    null,
    [
      'icon' => $icon->ikadenwa,
      'label' => Yii::t('app', 'Ika-Denwa'),
      'href' => 'https://ikadenwa.ink/',
    ],
    [
      'icon' => $icon->ikanakama,
      'label' => Yii::t('app', 'Ika-Nakama 2'),
      'href' => 'https://ikanakama.ink/',
    ],
    null,
    [
      'icon' => FA::fab('wordpress')->fw(),
      'label' => Yii::t('app', 'Blog'),
      'href' => 'https://blog.fetus.jp/',
    ],
    [
      'icon' => FA::fab('github-alt')->fw(),
      'label' => Yii::t('app', 'Source Code'),
      'href' => 'https://github.com/fetus-hina/stat.ink',
    ],
  ],
]);
