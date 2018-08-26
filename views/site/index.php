<?php
use app\assets\CounterAsset;
use app\assets\PaintballAsset;
use app\components\helpers\CombinedBattles;
use app\components\widgets\FA;
use app\components\widgets\SevenSegment;
use app\components\widgets\SnsWidget;
use app\components\widgets\battle\BattleListWidget;
use app\models\Battle;
use app\models\BlogEntry;
use app\models\Language;
use app\models\SupportLevel;
use app\models\User;
use yii\helpers\Html;

$this->context->layout = 'main';

// CounterAsset::register($this);
PaintballAsset::register($this);
?>
<div class="container">
  <div class="text-right mb-3">
    <?= Html::button(
      implode(' ', [
        FA::fas('language')->fw(),
        Html::encode('Switch Language / 言語切替'),
        FA::fas('caret-down')->fw(),
      ]),
      [
        'type' => 'button',
        'class' => 'btn btn-secondary btn-block mb-4',
        'data' => [
          'toggle' => 'modal',
          'target' => '#language-dialog',
        ],
      ]
    ) . "\n" ?>
    <?= Html::button(
      implode(' ', [
        FA::far('clock')->fw(),
        Html::encode(Yii::t('app', 'Time Zone')),
        FA::fas('caret-down')->fw(),
      ]),
      [
        'type' => 'button',
        'class' => 'btn btn-secondary btn-block mb-4',
        'data' => [
          'toggle' => 'modal',
          'target' => '#timezone-dialog',
        ],
      ]
    ) . "\n" ?>
  </div>
  <div class="text-right mb-0">
    Users:  
    <?= SevenSegment::widget([
      'label' => User::getRoughCount() ?? '?',
      'type' => 'users',
    ]) ?>,
    Battles:
    <?= SevenSegment::widget([
      'label' => Battle::getTotalRoughCount() ?? '?',
      'type' => 'battles',
    ]) ?>
  </div>
  </p>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-9">
      <h1 class="paintball" style="font-size:42px;margin-top:0">
        <?= Html::encode(Yii::$app->name) . "\n" ?>
      </h1>
      <p>
        <?= Html::encode(Yii::t('app', 'Staaaay Fresh!')) . "\n" ?>
      </p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
<?php if (file_exists(Yii::getAlias('@app/views/includes/sponsored.php'))): ?>
        <?= $this->render('/includes/sponsored') . "\n" ?>
<?php endif; ?>
    </div>
  </div>
<?php if (Yii::$app->language === 'ja-JP'): ?>
  <div class="bg-warning" style="margin-bottom:15px;padding:15px;border-radius:10px">
    <p>
      イカリング2からの取り込みを検討されている方は、次のようなアプリをご利用ください。（自己責任）
    </p>
    <ul>
      <li>
        <a href="https://github.com/hymm/squid-tracks/">SquidTracks</a> (Windows, MacOSインストーラあり)
      </li>
      <li>
        <a href="https://github.com/frozenpandaman/splatnet2statink">splatnet2statink</a>（知識と経験が必要）
      </li>
    </ul>
    <p style="margin-bottom:0">
      stat.ink自体にiksm_session, token あるいはパスワードを保存しての自動登録機能実装の予定はありません。
      （<a href="https://twitter.com/fetus_hina/status/895268629230493696">理由ツイート</a>）<br>
      iksm_session等の登録は、<a href="https://ja.wikipedia.org/wiki/%E3%82%BB%E3%83%83%E3%82%B7%E3%83%A7%E3%83%B3%E3%83%8F%E3%82%A4%E3%82%B8%E3%83%A3%E3%83%83%E3%82%AF">セッションハイジャック</a>を起こさせることに等しく、危険です。（最近だと、艦これの乗っ取り事件とかありましたね）<br>
      自分のiksm_sessionを何らかの方法で知ったとしても、それを他人には決して渡さないようにしてください。
    </p>
  </div>
<?php else: ?>
  <div class="bg-warning" style="margin-bottom:15px;padding:15px;border-radius:10px">
    <p>
      You can import automatically from SplatNet 2, use these apps: (USE AT YOUR OWN RISK)
    </p>
    <ul>
      <li>
        <a href="https://github.com/hymm/squid-tracks/">SquidTracks</a> (multi platform, available installer for Windows and MacOS)
      </li>
      <li>
        <a href="https://github.com/frozenpandaman/splatnet2statink">splatnet2statink</a> (multi platform, needs Python environment)
      </li>
    </ul>
    <p style="margin-bottom:0">
      We won't implement to import automatically to stat.ink for security reasons.
    </p>
  </div>
<?php endif; ?>
<?php $lang = Language::findOne(['lang' => Yii::$app->language]) ?>
<?php if ($lang && in_array((int)$lang->support_level_id, [SupportLevel::PARTIAL, SupportLevel::FEW], true)): ?>
    <p class="bg-danger" style="padding:15px;border-radius:10px">
      This language support is really limited at this time.<br>
<?php if ($lang->support_level_id === SupportLevel::FEW): ?>
      Only proper nouns translated. (e.g. weapons, stages)<br>
<?php endif ?>
      <a href="https://github.com/fetus-hina/stat.ink/wiki/Translation">We need your support!</a>
    </p>
<?php endif; ?>
  <p>
    <?= implode(' | ', [
      Yii::$app->user->isGuest
        ? Html::a(
          Html::encode(Yii::t('app', 'Join us')),
          ['user/register']
        )
        : Html::a(
          Html::encode(Yii::t('app', 'Your Battles')),
          ['show-user/profile', 'screen_name' => Yii::$app->user->identity->screen_name]
        ),
      Html::a(Html::encode(Yii::t('app', 'Getting Started')), ['site/start']),
      Html::a(Html::encode(Yii::t('app', 'FAQ')), ['site/faq']),
      Html::a(Html::encode(Yii::t('app', 'Stats: User Activity')), ['entire/users']),
    ]) . "\n" ?>
    <br>
    <?= implode(' | ', [
      '[2] ' . Html::a(Html::encode(Yii::t('app', 'Stats: K/D vs Win %')), ['entire/kd-win2']),
      '[2] ' . Html::a(Html::encode(Yii::t('app', 'Stats: Knockout Ratio')), ['entire/knockout2']),
      '[2] ' . Html::a(Html::encode(Yii::t('app', 'Stats: Weapons')), ['entire/weapons2']),
      '[1] ' . Html::a(Html::encode(Yii::t('app', 'Stats: Stages')), ['stage/index']),
      '[2] ' . Html::a(Html::encode(Yii::t('app', 'Download Stats')), ['download-stats/index']),
    ]) . "\n" ?>
  </p>
  <p>
    <?= implode(' | ', [
      Html::a(Html::encode(Yii::t('app', 'About support for color-blindness')), ['site/color']),
      Html::a(Html::encode(Yii::t('app', 'About image sharing with the IkaLog team')), ['site/privacy']),
    ]) . "\n" ?>
  </p>
  <?= SnsWidget::widget() . "\n" ?>
<?php $blogEntries = BlogEntry::find()
  ->orderBy(['at' => SORT_DESC])
  ->limit(3)
  ->asArray()
  ->all();
if ($blogEntries):
?>
  <p class="bg-success" style="padding:15px;border-radius:10px">
    <?= implode(' | ', array_map(
      function (array $entry) : string {
        $t = (new DateTimeImmutable($entry['at']))->setTimeZone(new DateTimeZone(Yii::$app->timeZone));
        return Html::tag(
          'span',
          vsprintf('%s (%s)', [
            Html::a(
              Html::encode($entry['title']),
              $entry['url']
            ),
            Html::tag(
              'time',
              Html::encode(
                Yii::$app->formatter->asRelativeTime($t)
              ),
              ['datetime' => $t->format(DateTime::ATOM)]
            ),
          ]),
          []
        );
      },
      $blogEntries
    )) . "\n" ?>
  </p>
<?php endif; ?>

  <?= $this->render('_index_schedule') . "\n" ?>

<?php if (!Yii::$app->user->isGuest): ?>
<?php $ident = Yii::$app->user->identity ?>
<?php $battles = CombinedBattles::getUserRecentBattles($ident, 12) ?>
<?php if ($battles): ?>
  <h2>
    <?= Html::a(
      Html::encode(
        Yii::t('app', '{0}\'s Battles', $ident->name)
      ),
      ['show-user/profile', 'screen_name' => $ident->screen_name]
    ) . "\n" ?>
  </h2>
  <?= BattleListWidget::widget(['models' => $battles]) . "\n" ?>
<?php endif; endif; ?>
  <h2>
    <?= Html::encode(Yii::t('app', 'Recent Battles')) . "\n" ?>
  </h2>
  <?= BattleListWidget::widget(['models' => CombinedBattles::getRecentBattles(100)]) . "\n" ?>
</div>
