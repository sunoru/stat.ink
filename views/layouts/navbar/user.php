<?php
use app\components\widgets\FA;
use app\components\widgets\NavBarMenu;
use app\components\widgets\UserIcon;
use yii\helpers\Html;

$user = Yii::$app->user->identity ?? null;
echo NavBarMenu::widget([
  'icon' => $user ? FA::hack(UserIcon::widget())->fw() : FA::fas('user')->fw(),
  'label' => $user->name ?? Yii::t('app', 'Guest'),
  'items' => [
    $user ? [
      'icon' => FA::fas('user')->fw(),
      'label' => Yii::t('app', 'Your Battles'),
      'href' => ['/show-user/profile', 'screen_name' => $user->screen_name],
    ] : false,
    $user ? [
      'icon' => FA::hack('┣')->fw(),
      'label' => Yii::t('app', 'Splatoon 2'),
      'href' => ['/show-v2/user', 'screen_name' => $user->screen_name],
    ] : false,
    $user ? [
      'icon' => FA::hack('┗')->fw(),
      'label' => Yii::t('app', 'Splatoon'),
      'href' => ['/show/user', 'screen_name' => $user->screen_name],
    ] : false,
    $user ? [
      'icon' => FA::fas('wrench')->fw(),
      'label' => Yii::t('app', 'Profile and Settings'),
      'href' => ['/user/profile'],
    ] : false,
    $user ? null : false,
    $user ? [
      'icon' => FA::fas('sign-out-alt')->fw(),
      'label' => Yii::t('app', 'Logout'),
      'href' => ['/user/logout'],
    ] : false,
    $user ? false : [
      'icon' => FA::fas('sign-in-alt')->fw(),
      'label' => Yii::t('app', 'Login'),
      'href' => ['/user/login'],
    ],
    $user || !(Yii::$app->params['twitter']['read_enabled'] ?? false) ? false : [
      'icon' => FA::hack('┗')->fw() . FA::fab('twitter')->fw(),
      'label' => Yii::t('app', 'Log in with Twitter'),
      'href' => ['/user/login-with-twitter'],
    ],
    $user ? false : [
      'icon' => FA::fas('plus')->fw(),
      'label' => Yii::t('app', 'Register'),
      'href' => ['/user/register'],
    ],
    null,
    [
      'icon' => FA::far(null)->fw(),
      'label' => Yii::t('app', 'Color-Blind Support'),
      'href' => 'javascript:;',
      'options' => ['id' => 'toggle-color-lock'],
    ],
    [
      'icon' => FA::far(null)->fw(),
      'label' => Yii::t('app', 'Use full width of the screen'),
      'href' => 'javascript:;',
      'options' => ['id' => 'toggle-use-fluid'],
    ],
  ],
]);
