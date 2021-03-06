`GET /api/v2/stage`
===================

| | |
|-|-|
|URL|`https://stat.ink/api/v2/stage`|
|Return-Type|`application/json`|
|認証|なし|

マップ（ステージ）の一覧をJSON形式、[`stage`構造体](struct/stage.md)の配列で返します。
各マップの`key`が他のAPIで利用するときの値です。

出現順に規定はありません。（利用者側で適切に並び替えてください）

```js
[
    {
        "key": "battera",
        "splatnet": 0,
        "name": {
            "ja_JP": "バッテラストリート",
            "en_US": "The Reef",
            "en_GB": "The Reef",
            "es_ES": "Barrio Congrio",
            "es_MX": "Barrio Congrio"
        },
        "short_name": {
            "ja_JP": "バッテラ",
            "en_US": "Reef",
            "en_GB": "Reef",
            "es_ES": "Barrio",
            "es_MX": "Barrio"
        },
        "area": 2450,
        "release_at": {
            "time": 1490382000,
            "iso8601": "2017-03-24T19:00:00+00:00"
        }
    },
    // ...
]
```

v1との差異
----------

- このAPIは`map`という名前でした。
- `short_name`が追加されています。
- `splatnet` が追加されています。

----

[![CC-BY 4.0](https://stat.ink/static-assets/cc/cc-by.svg)](http://creativecommons.org/licenses/by/4.0/deed.ja)

この文章は[Creative Commons - 表示 4.0 国際](http://creativecommons.org/licenses/by/4.0/deed.ja)の下にライセンスされています。
