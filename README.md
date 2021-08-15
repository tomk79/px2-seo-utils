# px2-seo-utils

[Pickles 2](https://pickles2.pxt.jp/) に、SEOに関するユーティリティを追加します。


## セットアップ - Setup

### 1. インストール - Installation

Pickles 2 をセットアップしたあとに、次のコマンドを実行します。

```
$ composer require tomk79/px2-seo-utils;
```

### 2. `$conf->funcs->before_sitemap` に設定する

設定ファイル `config.php` (通常は `./px-files/config.php`) を編集し、次のように追記します。
テーマの後に実行されるように設定してください。

```php
$conf->funcs->before_sitemap = array(

    // 〜中略〜

    // SEO Utils
    tomk79\pickles2\px2_seo_utils\config::init(array(
        /* プラグインの設定 (後述) */
    )),

    // 〜中略〜

);
```

## 使い方 - Usage

### robots タグの出力

#### プラグイン設定

`robots->enable` を `true` に設定します。

```php
    // SEO Utils
    tomk79\pickles2\px2_seo_utils\config::init(array(

        'robots' => array(
            // metaタグ robots の自動挿入を有効にします。
            'enable' => true,
        ),

    )),
```

#### サイトマップを拡張する

サイトマップに次の列を追加します。

- `robots:follow`
- `robots:index`
- `robots:archive`

サイトマップに追加した拡張列に、各ページの設定を入力します。

- `on`、 `yes`、 `true`、 `1` のように入力した場合は、肯定の命令(例: `follow`) が出力されます。
- `off`、 `no`、 `false`、 `0` のように入力した場合は、否定の命令(例: `nofollow`) が出力されます。
- 空白か、列が未定義か、または `null` のように入力した場合は、出力されません。

3つの項目のうちの何れか1つ以上が設定されている場合、
`head` 要素の閉じタグの直前に、
`<meta name="robots" content="follow,noindex" />` のようなコードが出力されます。


#### metaタグを直接取得する

直接タグを取得したい場合は、次の例のように `$seoUtils->robots()->tag()` メソッドから取得できます。
このとき、 同時に `X-Robots-Tag` ヘッダーが発行されます。

```php
<html>
<head>
<?php
$seoUtils = new \tomk79\pickles2\px2_seo_utils\main($px);
$tag = $seoUtils->robots()->tag(array(
    'follow'=>'no',
    'index'=>'',
    'archive'=>'',
));
echo $tag;
?>
</head>
</html>
```

### sitemap.xml の生成

#### プラグイン設定

`sitemapXml->enable` を `true` に設定します。

```php
    // SEO Utils
    tomk79\pickles2\px2_seo_utils\config::init(array(

        'sitemapXml' => array(
            // sitemap.xml の自動生成機能を有効にします。
            'enable' => true,

            // ここに設定したパスへのリクエストをトリガーに、sitemap.xml が生成されます。
            'trigger' => '/index.html',

            // 生成した sitemap.xml の保存先のパスです。
            // `.px_execute.php` が置かれているディレクトリをルートとして設定します。
            'dist' => '/sitemap.xml',
        ),

    )),
```



## 更新履歴 - Change log

### tomk79/px2-seo-utils v0.1.0 (2021年8月15日)

- Initial Release.


## ライセンス - License

MIT License


## 作者 - Author

- Tomoya Koyanagi <tomk79@gmail.com>
- website: <https://www.pxt.jp/>
- Twitter: @tomk79 <https://twitter.com/tomk79/>
