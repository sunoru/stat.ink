<?php
use app\assets\PaintballAsset;
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
        <li class="nav-item dropdown">
          <?= $this->render('/layouts/navbar/language') . "\n" ?>
        </li>
        <li class="nav-item dropdown">
          <?= $this->render('/layouts/navbar/timezone') . "\n" ?>
        </li>
        <li class="nav-item dropdown">
          <?= $this->render('/layouts/navbar/link') . "\n" ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php __halt_compiler(); ?>
  <div class="container-fluid">
    <div class="container">
      <div class="navbar-header">
        <?= Html::tag(
          'button',
          implode('', [
            Html::tag('span', 'Toggle navigation', ['class' => 'sr-only']),
            Html::tag('span', '', ['class' => 'icon-bar']),
            Html::tag('span', '', ['class' => 'icon-bar']),
            Html::tag('span', '', ['class' => 'icon-bar']),
          ]),
          [
            'type' => 'button',
            'class' => 'navbar-toggle collapsed',
            'data' => [
              'toggle' => 'collapse',
              'target' => '#bs-example-navbar-collapse-1',
            ],
            'aria-expanded' => "false",
          ]
        ) . "\n" ?>
        <?= Html::a(Html::encode(Yii::$app->name), '/', [
          'class' => 'navbar-brand paintball',
          'style' => [
            'font-size' => '24px',
          ],
          'itemprop' => 'name',
        ]) . "\n" ?>
        <span class="navbar-brand ip-via-badge">
<?php $this->registerCss('.ip-via-badge{position:relative;top:-3px}') ?>
          <?= IpVersionBadgeWidget::widget() . "\n" ?>
        </span>
      </div>
      <div itemscope itemtype="http://schema.org/SiteNavigationElement" class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <?= $this->render('/layouts/navbar/user') . "\n" ?>
          </li>
          <li class="dropdown">
            <?= $this->render('/layouts/navbar/language') . "\n" ?>
          </li>
          <li class="dropdown">
            <?= $this->render('/layouts/navbar/timezone') . "\n" ?>
          </li>
          <li class="dropdown">
            <?= $this->render('/layouts/navbar/link') . "\n" ?>
          </li>
        </ul>
<?php if (!Yii::$app->user->isGuest) { ?>
        <ul class="nav navbar-nav navbar-right">
          <li style="margin-right:1ex">
            <?= Html::tag(
              'button',
              implode('', [
                Html::tag('span', '', ['class' => 'fas fa-fw fa-edit']),
                Html::encode(Yii::t('app', 'Splatoon 2')),
              ]),
              [
                'id' => 'battle-input2-btn',
                'class' => 'btn btn-primary navbar-btn',
                'title' => Yii::t('app', 'New battle'),
                'disabled' => true,
              ]
            ) . "\n" ?>
          </li>
        </ul>
<?php } ?>
      </div>
    </div>
  </div>
</nav>
