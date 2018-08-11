<?php
namespace app\components\widgets;

use Yii;
use app\models\Country;
use app\models\Timezone;
use app\models\TimezoneGroup;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

class TimezoneDialog extends Dialog
{
    public function init()
    {
        parent::init();
        $this->title = implode(' ', [
            FA::far('clock')->fw(),
            Html::encode(Yii::t('app', 'Time Zone')),
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
            $this->currentTimezone() . $this->renderZoneGroups(),
            ['class' => 'list-group-flush']
        );
    }

    private function currentTimezone(): string
    {
        if (!$tz = Timezone::findOne(['identifier' => Yii::$app->timeZone])) {
            return '';
        }

        return $this->renderTimezone($tz, true);
    }

    private function renderTimezone(Timezone $tz, bool $isCurrent): string
    {
        if ($isCurrent) {
            return Html::tag(
                'div',
                $this->renderTimezoneDetail($tz),
                ['class' => 'list-group-item bg-primary text-light']
            );
        } else {
            return Html::a(
                $this->renderTimezoneDetail($tz),
                'javascript:;',
                [
                    'class' => 'list-group-item timezone-change text-dark',
                    'data' => [
                        'tz' => $tz->identifier,
                    ],
                ]
            );
        }
    }

    private function renderTimezoneDetail(Timezone $tz): string
    {
        $flags = implode(' ', array_map(
            function (Country $country): string {
                $flag = Html::tag('span', '', ['class' => [
                    'flag-icon',
                    'flag-icon-' . $country->key,
                ]]);
                return FA::hack($flag)->fw();
            },
            $tz->countries
        ));

        return Html::tag(
            'div',
            implode('', [
                Html::tag(
                    'span',
                    $flags . ' ' . Html::encode(Yii::t('app-tz', $tz->name))
                ),
                Html::tag(
                    'span',
                    Html::encode($tz->identifier),
                    ['class' => 'd-none d-sm-inline small']
                ),
            ]),
            ['class' => 'd-flex justify-content-between']
        );
    }

    private function renderZoneGroups(): string
    {
        $ret = '';
        $currentTz = Yii::$app->timeZone;
        $groups = TimezoneGroup::find()->with(['timezones', 'timezones.countries'])->all();
        foreach ($groups as $group) {
            if ($group->timezones) {
                $ret .= $this->renderZoneGroupHeader($group);
                $ret .= Html::tag(
                    'div',
                    implode('', array_map(
                        function (Timezone $tz) use ($currentTz): string {
                            return $this->renderTimezone($tz, $currentTz === $tz->identifier);
                        },
                        $group->timezones
                    )),
                    [
                        'class' => 'collapse',
                        'id' => sprintf(
                            'tzgroup-%s',
                            trim(preg_replace('/[^a-z]+/', '-', strtolower($group->name)), '-')
                        ),
                    ]
                );
            }
        }
        return $ret;
    }

    private function renderZoneGroupHeader(TimezoneGroup $group): string
    {
        return Html::a(
            Html::encode(Yii::t('app', $group->name)),
            'javascript:;',
            [
                'class' => 'list-group-item bg-secondary text-white pt-2 pb-2 small',
                'role' => 'button',
                'data' => [
                    'toggle' => 'collapse',
                    'target' => sprintf(
                        '#tzgroup-%s',
                        trim(preg_replace('/[^a-z]+/', '-', strtolower($group->name)), '-')
                    ),
                ],
            ]
        );
    }
}
