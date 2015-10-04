{{strip}}
  {{set layout="main.tpl"}}
  {{use class="app\models\Battle"}}
  <div class="container">
    <h1>
      {{$app->name|escape}}
    </h1>
    <p>
      {{'Staaaay Fresh!'|translate:'app'|escape}}<br>
      {{if $app->user->isGuest}}
        <a href="{{url route="user/register"}}">{{'Join us'|translate:'app'|escape}}</a>
      {{else}}
        {{$ident = $app->user->identity}}
        <a href="{{url route="show/user" screen_name=$ident->screen_name}}">{{'Your Battles'|translate:'app'|escape}}</a>
      {{/if}} | <a href="{{url route="site/start"}}">{{"What's this?"|translate:'app'|escape}}</a>
    </p>

    <div id="sns">
      {{\app\assets\TwitterWidgetAsset::register($this)|@void}}
      <a class="twitter-share-button" href="https://twitter.com/intent/tweet" data-count="none"><span class="fa fa-twitter"></span></a>
    </div>

    {{$battles = Battle::find()->with('user')->limit(100)->all()}}
    <ul class="battles">
      {{$imagePlaceholder = $app->assetManager->getAssetUrl(
          $app->assetManager->getBundle('app\assets\AppAsset'),
          'no-image.png'
        )}}
      {{foreach $battles as $battle}}
        <li>
          <div class="battle">
            <div class="battle-image">
              <a href="{{url route="show/battle" screen_name=$battle->user->screen_name battle=$battle->id}}">
                {{$image = null}}
                {{if $battle->battleImageJudge}}
                  {{$image = $battle->battleImageJudge}}
                {{elseif $battle->battleImageResult}}
                  {{$image = $battle->battleImageResult}}
                {{/if}}
                <img src="{{$imagePlaceholder|escape}}" class="lazyload" data-src="{{$image->url|default:''|escape}}">
              </a>
            </div>
            <div class="battle-data">
              <a href="{{url route="show/user" screen_name=$battle->user->screen_name}}">{{$battle->user->name|escape}}</a>
            </div>
          </div>
        </li>
      {{/foreach}}
    </ul>
  </div>
{{/strip}}
