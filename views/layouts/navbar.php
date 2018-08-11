<?php
use app\assets\PaintballAsset;
use app\components\widgets\FA;
use app\components\widgets\IpVersionBadgeWidget;
use yii\helpers\Html;

PaintballAsset::register($this);
$this->registerCss('.ip-via-badge{position:relative;top:-3px}');
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">
      <?= Html::a(
        Html::encode(Yii::$app->name),
        '/',
        [
          'class' => 'text-white paintball p-0',
          'style' => [
            'font-size' => '24px',
          ],
          'itemprop' => 'name',
        ]
      ) . "\n" ?>
      <span class="ip-via-badge ml-2">
        <?= IpVersionBadgeWidget::widget() . "\n" ?>
      </span>
    </span>
    <?= Html::tag(
      'button',
      Html::tag('span', '', ['class' => 'navbar-toggler-icon']),
      [
        'class' => 'navbar-toggler',
        'type' => 'button',
        'data' => [
          'toggle' => 'collapse',
          'target' => '#navbar-content',
        ],
        'aria-controls' => 'navbar-content',
        'aria-expanded' => 'false',
        'aria-label' => Yii::t('app', 'Toggle navigation'),
      ]
    ) . "\n" ?>

    <div itemscope itemtype="http://schema.org/SiteNavigationElement" class="collapse navbar-collapse" id="navbar-content">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
          <?= $this->render('/layouts/navbar/user') . "\n" ?>
        </li>
        <li class="nav-item dropdown"><?= Html::a(
          FA::fas('language')->fw() . ' Language',
          'javascript:;',
          [
            'class' => 'nav-link dropdown-toggle',
            'role' => 'button',
            'data' => [
              'toggle' => 'modal',
              'target' => '#language-dialog',
            ],
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
          ]
        ) ?></li>
        <li class="nav-item dropdown"><?= Html::a(
          FA::far('clock')->fw() . ' ' . Html::encode(Yii::t('app', 'Time Zone')),
          'javascript:;',
          [
            'class' => 'nav-link dropdown-toggle',
            'role' => 'button',
            'data' => [
              'toggle' => 'modal',
              'target' => '#timezone-dialog',
            ],
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false',
          ]
        ) ?></li>
        <li class="nav-item dropdown">
          <?= $this->render('/layouts/navbar/link') . "\n" ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
